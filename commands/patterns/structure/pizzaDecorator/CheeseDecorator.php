<?php

namespace app\commands\patterns\structure\pizzaDecorator;

class CheeseDecorator extends PizzaDecorator
{
    public function getDescription(): string
    {
        return parent::getDescription() . ", Cheese";
    }

    public function getCost(): float
    {
        return parent::getCost() + 1.5;
    }
}