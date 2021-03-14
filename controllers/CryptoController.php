<?php

namespace app\controllers;

use app\components\api\CryptoCompare;
use app\models\CryptoRequestForm;
use app\models\AltcoinHistory;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Query;
use Yii;

class CryptoController extends Controller
{
    /**
     * @return string
     */
    public function actionRates()
    {
        $cryptoForm = new CryptoRequestForm();
        $prices = $this->getPrices($cryptoForm);
        return $this->render('rates', ['cryptoRequestForm' => $cryptoForm, 'prices' => $prices]);
    }

    /**
     * @return string
     */
    public function actionCharts()
    {
        $altcoins = (new Query())->select(['btc', 'eth', 'ltc', 'xrp', 'atom', 'xmr', 'bnb'])
            ->from('altcoin_history')
            ->orderBy('id DESC')
            ->one();

        return $this->render('charts', [
            'altcoins' => $altcoins
        ]);
    }

    /**
     * @param string|null $altcoin
     * @return array
     * @throws Exception
     */
    public function actionGetDataCharts($altcoin = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = (new AltcoinHistory())->getDataCharts($altcoin);
        return ['success' => true, 'data' => $data];
    }

    /**
     * @param CryptoRequestForm $cryptoForm
     * @return array
     */
    protected function getPrices(CryptoRequestForm $cryptoForm): array
    {
        $app = Yii::$app;
        $data = $app->request->get();
        $prices = ['success' => false];
        if ($cryptoForm->load($data)) {
            $prices = (new CryptoCompare())->getMultiPrice($cryptoForm->altcoinList, $cryptoForm->currencyList);
            if ($prices['error']) {
                $app->session->setFlash('danger', $prices['error']);
            }
        }
        return $prices;
    }
}