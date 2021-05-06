<?php

namespace app\components\api;

use yii\httpclient\Response;

class ResponseChecker
{
    /** @var Response  */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        if ($this->response->isOk) {
            $dataResponse = $this->response->getData();
            if (isset($dataResponse['Response']) && $dataResponse['Response'] == 'Error') {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        $data = $this->response->getData();
        return $data['Message'] ?? 'Что то пошло не так...';
    }
}