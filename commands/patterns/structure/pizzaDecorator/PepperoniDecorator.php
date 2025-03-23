<?php

namespace app\commands\patterns\structure\pizzaDecorator;

class PepperoniDecorator extends PizzaDecorator
{
    public function getDescription(): string
    {
        return parent::getDescription() . ", Pepperoni";
    }

    public function getCost(): float
    {
        return parent::getCost() + 2.0;
    }
}