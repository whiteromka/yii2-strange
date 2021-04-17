<?php

namespace app\controllers;

use app\components\api\CryptoCompare;
use app\models\Altcoin;
use app\models\AltcoinHistoryData;
use app\models\AltcoinWatcher;
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
        $altcoins = Altcoin::find()->with(['altcoinWatchers'])->all();
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
            'altcoins' => $altcoins,
            'altcoinWatcher' => new AltcoinWatcher()
        ]);
    }

    /**
     * Adding watcher
     *
     * @return Response
     */
    public function actionAddWatcher()
    {
        $aw = new AltcoinWatcher();
        if ($aw->load(Yii::$app->request->post())) {
            $aw->expectation = $aw->wish_price > $aw->price_at_conclusion
                ? AltcoinWatcher::EXPECTATION_UP : AltcoinWatcher::EXPECTATION_DOWN;
            if (!$aw->save()) {
                Yii::$app->session->setFlash('danger', current($aw->firstErrors));
            }
        }
        return $this->redirect(['add-altcoin']);
    }

    /**
     * @param int $id
     * @return array
     */
    public function actionDeleteWatcher(int $id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        AltcoinWatcher::deleteAll(['id'=>$id]);
        return ['success' => true];
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