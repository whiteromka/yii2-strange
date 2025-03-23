<?php

namespace app\commands\patterns\structure\pizzaDecorator;

interface Pizza
{
    public function getDescription(): string;
    public function getCost(): float;
}