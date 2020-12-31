<?php

namespace app\commands;

use app\models\City;
use yii\console\Controller;
use Yii;
use yii\db\Exception;

/**
 * Class CityController
 * @package app\commands
 */
class CityController extends Controller
{
    /**
     * Fill data in table city from file cities.json
     *
     * @throws Exception
     */
    public function actionBatchInsert() : void
    {
        $start = time();
        $cityList = $this->parseCitiesFromFile();
        $attributes = ['name', 'district', 'population', 'subject', 'lat', 'lon'];
        echo PHP_EOL . Yii::$app->db->createCommand()->batchInsert(City::tableName(), $attributes, $cityList)->execute();
        $end = time();
        echo PHP_EOL . 'time = ' . ($end - $start);
    }

    /**
     * @param string|null $jsonFile
     * @return array
     */
    protected function parseCitiesFromFile(string $jsonFile = null) : array
    {
        if (!$jsonFile) {
           $jsonFile = Yii::getAlias('@app/web/cities.json');
        }
        $json = file_get_contents($jsonFile);
        $cities = json_decode($json, true);
        return $this->recreateCities($cities);
    }

    /**
     * @param array $cities
     * @return array
     */
    protected function recreateCities(array $cities) : array
    {
        $cities = array_map(function($city) {
            return [
                $city['name'] ?? null,
                $city['district'] ?? null,
                $city['population'] ?? null,
                $city['subject'] ?? null,
                $city['coords']['lat'] ?? null,
                $city['coords']['lon'] ?? null,
            ];
        }, $cities);
        return $cities;
    }
}