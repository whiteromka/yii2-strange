<?php

namespace app\commands\patterns\behaviour\paymentStrategy;

interface IPayment
{
    public function pay(float $sum);
}