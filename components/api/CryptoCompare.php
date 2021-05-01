<?php

namespace app\components\api;

use Exception;
use Yii;
use yii\httpclient\Client;
use yii\httpclient\Response;

class CryptoCompare
{
    /** @var string */
    protected $apiUrl;

    /** @var string */
    protected $key;

    public function __construct()
    {
        $this->apiUrl = Yii::$app->params['cryptoCompareApi']['url'];
        $this->trySetApiKey();
    }

    public function trySetApiKey(): void
    {
        $apiKey = Yii::$app->params['cryptoCompareApi']['key'];
        if ($apiKey && $apiKey != '?') {
            $this->key = $apiKey;
        }
    }

    /**
     * @return bool
     */
    public function isSetApiKey(): bool
    {
        return $this->key ? true : false;
    }

    /**
     * @param array $altcoinList
     * @param array $currencyList
     * @return array
     */
    public function getMultiPrice(array $altcoinList, array $currencyList = ['USD']): array
    {
        $altcoins = implode(',', $altcoinList);
        $currencies = implode(',', $currencyList);
        $url = $this->apiUrl . "pricemulti?fsyms=$altcoins&tsyms=$currencies";
        return $this->request($url);
    }

    /**
     * @param array $altcoinList
     * @param array $currencyList
     * @return array
     */
    public function getPrettyMultiPrice(array $altcoinList, array $currencyList = ['USD']): array
    {
        $reconstructedData = [];
        $result = $this->getMultiPrice($altcoinList, $currencyList);
        if ($result['success']) {
            foreach ($result['data'] as $altcoin => $priceData) {
                $reconstructedData[$altcoin] = $priceData['USD'];
            }
        }
        $result['data'] = $reconstructedData;
        return $result;
    }

    /**
     * @param string $altcoin
     * @param integer $unixTime
     * @return array
     */
    public function getPriceOnDate(string $altcoin, int $unixTime): array
    {
        $url = $this->apiUrl . "pricehistorical?fsym=$altcoin&tsyms=USD&ts=$unixTime";
        return $this->request($url);
    }

    /**
     * @return array
     */
    public function getBlockchainList(): array
    {
        $url = $this->apiUrl . 'blockchain/list' . '?&api_key=' . $this->key;
        return $this->request($url);
    }

    /**
     * @param string $url
     * @return array
     */
    protected function request(string $url): array
    {
        try {
            $response = (new Client())->createRequest()->setMethod('GET')->setUrl($url)->send();
            $result = $this->responseIsOk($response) ?
                ['data' => $response->data, 'success' => true, 'error' => false] :
                ['data' => [], 'success' => false, 'error' => $this->getResponseError($response)];
        } catch (Exception $e) {
            $result = ['data' => [], 'success' => false, 'error' => $e->getMessage()];
        }
        return $result;
    }

    /**
     * @param Response $response
     * @return bool
     */
    protected function responseIsOk(Response $response): bool
    {
        if ($response->isOk) {
            $dataResponse = $response->getData();
            if (isset($dataResponse['Response']) && $dataResponse['Response'] == 'Error') {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @param Response $response
     * @return string
     */
    protected function getResponseError(Response $response): string
    {
        $dataResponse = $response->getData();
        return $dataResponse['Message'] ?? 'Что то пошло не так...';
    }
}