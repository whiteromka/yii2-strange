<?php

namespace app\modules\shop\controllers;

use app\components\shop\CartManager;
use yii\web\Controller;

class CartController extends Controller
{
    /** @var CartManager */
    protected $cartManager;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cartManager = new CartManager();
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd(int $productId, int $count = 1)
    {
        $this->cartManager->add($productId, $count);
    }
}
