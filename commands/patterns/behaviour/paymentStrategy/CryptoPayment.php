<?php

namespace app\commands\patterns\behaviour\paymentStrategy;

class CryptoPayment implements IPayment
{
    public function pay(float $sum)
    {
         echo 'оплата через крипту на сумму ' . $sum;
    }
}