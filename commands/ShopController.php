<?php

namespace app\commands;

use app\components\creators\CategoryCreator;
use app\components\creators\ProductCreator;

class ShopController extends BaseController
{
    public function actionFill()
    {
        (new CategoryCreator())->fill();
        (new ProductCreator())->fill();
    }
}