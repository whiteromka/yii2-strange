<?php

namespace app\components\api;

use yii\httpclient\Client;
use app\models\Passport;
use app\models\City;
use Exception;
use Yii;

/**
 * Class YandexWeather
 * @package app\components\api
 */
class YandexWeather
{
    /** @var float|int */
    public $cacheDur = 3 * 60;

    /**
     * @param Passport $passport
     * @return array
     */
    public function getByPassport(Passport $passport) : array
    {
        return $this->getByCity($passport->city);
    }

    /**
     * @param string $city
     * @return array
     */
    public function getByCity(string $city) : array
    {
        /** @var City $city */
        $city = City::find()->where(['name' => $city])->one();
        if (!$city) {
            return ['success' => false, 'error' => 'Нет такого города в нашей БД!'];
        }

        $cache = Yii::$app->cache;
        $weather = $cache->get($city->name);
        if (!$weather) {
            $weather = $this->sendRequest($city);
            if ($weather && $weather['success']) {
                $cache->set($city->name, $weather, $this->cacheDur);
            }
        }
        return $weather;
    }

    /**
     * @param City $city
     * @return array
     */
    protected function sendRequest(City $city) : array
    {
        try {
            $weather = [];
            $response = (new Client())->createRequest()
                ->setMethod('GET')
                ->setHeaders(['X-Yandex-API-Key' => Yii::$app->params['yandexApiWeather']['key']])
                ->setUrl(Yii::$app->params['yandexApiWeather']['url'] . "?lat={$city->lat}&lon={$city->lon}")
                ->send();

            if ($response->isOk) {
                $weather = $response->data;
                $weather['success'] = true;
                $weather['fact']['icon'] = 'https://yastatic.net/weather/i/icons/blueye/color/svg/'.$weather['fact']['icon'].'.svg';
                $weather['fact']['wind_dir'] = self::getWindDir($weather['fact']['wind_dir']);
                $weather['fact']['season'] = self::getSeason($weather['fact']['season']);
            } else {
                $weather['success'] = false;
                $weather['error'] = 'Что то пошло не так. Попробуйте повторить запрос позже.';
            }
        } catch (Exception $e) {
            $weather['success'] = false;
            $weather['error']  = $e->getMessage();
        }

        return $weather;
    }

    /**
     * @param string $widDir
     * @return mixed
     */
    protected static function getWindDir(string $widDir)
    {
        $yandexWidDir = [
            'nw' => 'северо-западное',
            'n' => 'северное',
            'ne' => 'северо-восточное',
            'e' => 'восточное',
            'se' => 'юго-восточное',
            's'=>'южное',
            'sw' => 'юго-западное',
            'w' => 'западное',
            'с' => 'штиль'
        ];
        return $yandexWidDir[$widDir];
    }

    /**
     * @param string $season
     * @return mixed
     */
    protected static function getSeason(string $season)
    {
        $yandexSeasons = [
            'summer' => 'лето',
            'autumn' => 'осень',
            'winter' => 'зима',
            'spring' => 'весна'
        ];
        return $yandexSeasons[$season];
    }
}