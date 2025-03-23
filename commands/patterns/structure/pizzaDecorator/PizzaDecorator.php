<?php

namespace app\commands\patterns\structure\pizzaDecorator;

abstract class PizzaDecorator implements Pizza {

    protected $pizza;

    public function __construct(Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    public function getDescription(): string
    {
        return $this->pizza->getDescription();
    }

    public function getCost(): float
    {
        return $this->pizza->getCost();
    }
}