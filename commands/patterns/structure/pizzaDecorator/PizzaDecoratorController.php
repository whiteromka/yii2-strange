<?php

namespace app\commands\patterns\structure\pizzaDecorator;

use yii\console\Controller;

class PizzaDecoratorController extends Controller
{
    // pizza-decorator/index
    public function actionIndex()
    {
        $pizza = new BasicPizza(); // Создаем базовую пиццу
        $pizza = new CheeseDecorator($pizza); // Добавляем сыр
        $pizza = new PepperoniDecorator($pizza); // Добавляем пепперони

        // Получаем описание и стоимость пиццы
        echo "Description: " . $pizza->getDescription() . "\n";
        echo "Cost: $" . $pizza->getCost() . "\n";
        die;
    }
}