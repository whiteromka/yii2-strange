<?php

namespace app\controllers;

use app\components\api\CryptoCompare;
use app\models\AltcoinHistory;
use app\models\CryptoRequestForm;
use yii\web\Controller;

class CryptoController extends Controller
{
    public function actionIndex($save = null)
    {
        $cryptoForm = new CryptoRequestForm();
        $prices = $this->getPrices($cryptoForm, $save);
        return $this->render('index', ['cryptoRequestForm' => $cryptoForm, 'prices' => $prices]);
    }

    /**
     * @param CryptoRequestForm $cryptoForm
     * @param bool|null $save
     * @return array
     */
    protected function getPrices(CryptoRequestForm $cryptoForm): array
    {
        $app = \Yii::$app;
        $data = $app->request->get();
        $prices = ['success' => false];
        if ($cryptoForm->load($data)) {
            $prices = (new CryptoCompare())
                ->getMultiPrice('pricemulti', $cryptoForm->altcoinList, $cryptoForm->currencyList);
            if ($prices['error']) {
                $app->session->setFlash('danger', $prices['error']);
            }
            if ($cryptoForm->save && $prices['success']) {
                $save = AltcoinHistory::saveData($prices['data']);
                if (!$save['success']) {
                    $app->session->setFlash('danger', $save['error']);
                }
            }
        }
        return $prices;
    }
}