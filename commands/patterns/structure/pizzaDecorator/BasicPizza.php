<?php

namespace app\commands\patterns\structure\pizzaDecorator;

class BasicPizza implements Pizza
{
    public function getDescription(): string
    {
        return "Basic Pizza";
    }

    public function getCost(): float
    {
        return 5.0;
    }
}