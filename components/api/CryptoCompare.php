<?php

namespace app\components\api;

use Exception;
use Yii;
use yii\httpclient\Client;

class CryptoCompare
{
    /**
     * @param string $method
     * @param array $altcoinList
     * @param array $currencyList
     * @return array
     */
    public function getMultiPrice(string $method, array $altcoinList, array $currencyList): array
    {
        $cache = Yii::$app->cache;
        $cacheKey = $method .'_'. implode(',', $altcoinList) .'_'. implode(',', $currencyList);
        $prices = $cache->getOrSet($cacheKey, function() use ($method, $altcoinList, $currencyList) {
            return $this->sendRequest($method, $altcoinList, $currencyList);
        }, 100);

        return $prices;
    }
    
    /**
     * @param string $method
     * @param array $altcoinList
     * @param array $currencyList
     * @return array
     */
    protected function sendRequest(string $method, array $altcoinList, array $currencyList): array
    {
        $altcoinList = implode(',', $altcoinList);
        $currencyList = implode(',', $currencyList);
        try {
            $response = (new Client())->createRequest()
                ->setMethod('GET')
                ->setUrl(Yii::$app->params['cryptoCompareApi']['url'] . $method .
                    "?fsyms={$altcoinList}&tsyms={$currencyList}")
                ->send();

            if ($response->isOk) {
                $prices = ['data' => $response->data, 'success' => true, 'error' => false];
            } else {
                $prices = ['data' => [], 'success' => false, 'error' => 'Что то пошло не так. Попробуйте повторить запрос позже.'];
            }
        } catch (Exception $e) {
            $prices = ['data' => [], 'success' => false, 'error' => $e->getMessage()];
        }

        return $prices;
    }
}