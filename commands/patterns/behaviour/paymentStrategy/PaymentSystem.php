<?php

namespace app\commands\patterns\behaviour\paymentStrategy;

class PaymentSystem
{
    private IPayment $payment;

    public function __construct(IPayment $payment)
    {
        $this->payment = $payment;
    }

    public function getPayment(): IPayment
    {
        return $this->payment;
    }

    public function setPayment(IPayment $payment): void
    {
        $this->payment = $payment;
    }

    public function pay(float $sum)
    {
        $this->payment->pay($sum);
    }
}