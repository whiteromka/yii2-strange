<?php

namespace app\commands\patterns\behaviour\paymentStrategy;

use yii\console\Controller;

class PaymentStrategyController extends Controller
{
    // payment-strategy/index
    public function actionIndex()
    {
        $ps = new PaymentSystem(new PayPalPayment());
        $ps->pay(123);
        die;
    }
}