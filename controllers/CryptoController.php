<?php

namespace app\controllers;

use app\components\api\CryptoCompare;
use app\models\Altcoin;
use app\models\AltcoinHistoryData;
use app\models\CryptoRequestForm;
use app\models\AltcoinHistory;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class CryptoController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function actionAddAltcoin(): string
    {
        $altcoin = new Altcoin();
        $altcoins = Altcoin::find()->all();
        if ($altcoin->load(Yii::$app->request->post())) {
            $result = $altcoin->addNew();
            if ($result['success']) {
                Yii::$app->session->setFlash('success', 'Альткойн ' . $altcoin->name . ' добавлен');
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка. Альткойн ' . $altcoin->name . ' не был добавлен.' .
                    $result['error']);
            }
        }
        return $this->render('add-altcoin', [
            'altcoin' => $altcoin,
            'altcoins' => $altcoins
        ]);
    }

    /**
     * @return string
     */
    public function actionRates(): string
    {
        $app = Yii::$app;
        $cryptoForm = new CryptoRequestForm();
        $prices = ['success' => false];
        if ($cryptoForm->load($app->request->get())) {
            $prices = (new CryptoCompare())->getMultiPrice($cryptoForm->altcoinList, $cryptoForm->currencyList);
            if ($prices['error']) {
                $app->session->setFlash('danger', $prices['error']);
            }
        }
        return $this->render('rates', ['cryptoRequestForm' => $cryptoForm, 'prices' => $prices]);
    }

    /**
     * @return array
     */
    public function actionGetRates(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = (new CryptoCompare())->getMultiPrice(Altcoin::getAltcoinList(true), ['USD']);
        return $data;
    }

    /**
     * @return string
     */
    public function actionCharts(): string
    {
        $altcoins = Altcoin::map();
        $prices = (new AltcoinHistoryData())->getLastPrices();
        return $this->render('charts', [
            'altcoins' => $altcoins,
            'prices' => $prices
        ]);
    }

    /**
     * @param string|null $altcoin
     * @return array
     * @throws Exception
     */
    public function actionGetDataCharts($altcoin = null): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = (new AltcoinHistoryData())->getDataCharts($altcoin);
        return ['success' => true, 'data' => $data];
    }
}