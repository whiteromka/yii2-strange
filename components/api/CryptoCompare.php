<?php

namespace app\components\api;

use Exception;
use http\Client\Response;
use Yii;
use yii\httpclient\Client;

class CryptoCompare
{
    /** @var string */
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = Yii::$app->params['cryptoCompareApi']['url'];
    }

    /**
     * @param array $altcoinList
     * @param array $currencyList
     * @return array
     */
    public function getMultiPrice(array $altcoinList, array $currencyList): array
    {
        $cache = Yii::$app->cache;
        $cacheKey = implode(',', $altcoinList) .'_'. implode(',', $currencyList);
        $prices = $cache->getOrSet($cacheKey, function() use ($altcoinList, $currencyList) {
            return $this->requestPrice($altcoinList, $currencyList);
        }, 100);

        return $prices;
    }
    
    /**
     * @param array $altcoinList
     * @param array $currencyList
     * @return array
     */
    protected function requestPrice(array $altcoinList, array $currencyList): array
    {
        $altcoinList = implode(',', $altcoinList);
        $currencyList = implode(',', $currencyList);
        $url = $this->apiUrl . "pricehistorical?fsyms=$altcoinList&tsyms=$currencyList";
        try {
            $response = (new Client())->createRequest()->setMethod('GET')->setUrl($url)->send();
            $prices = $this->getPricesByResponse($response);
        } catch (Exception $e) {
            $prices = ['data' => [], 'success' => false, 'error' => $e->getMessage()];
        }
        return $prices;
    }

    /**
     * @param string $altcoin
     * @param integer $unixTime
     * @return array
     */
    public function getPriceOnDate(string $altcoin, int $unixTime): array
    {
        $url = $this->apiUrl . "pricehistorical?fsym=$altcoin&tsyms=USD&ts=$unixTime";
        try {
            $response = (new Client())->createRequest()->setMethod('GET')->setUrl($url)->send();
            $prices = $this->getPricesByResponse($response);
        } catch (Exception $e) {
            $prices = ['data' => [], 'success' => false, 'error' => $e->getMessage()];
        }
        return $prices;
    }

    /**
     * @param $response
     * @return array
     */
    protected function getPricesByResponse($response): array
    {
        if ($response->isOk) {
           return ['data' => $response->data, 'success' => true, 'error' => false];
        }
        return ['data' => [], 'success' => false, 'error' => 'Что то пошло не так. Попробуйте повторить запрос позже.'];
    }
}