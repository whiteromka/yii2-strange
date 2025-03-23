<?php

namespace app\commands\patterns\behaviour\paymentStrategy;

class PayPalPayment implements IPayment
{
    public function pay(float $sum)
    {
        echo 'оплата через PayPal на сумму ' . $sum;
    }
}