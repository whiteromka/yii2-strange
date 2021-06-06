<?php

namespace app\modules\shop\controllers;

use app\models\shop\Category;
use app\models\shop\Product;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCategory(int $id)
    {
        $category = Category::findOne(['id' => $id]);
        $products = Product::find()->where(['category_id' => $id])->all();
        return $this->render('category', compact('products', 'category'));
    }
}
