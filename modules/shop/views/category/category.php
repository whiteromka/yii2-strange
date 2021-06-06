<?php

use app\models\shop\Category;
use app\models\shop\Product;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var Category $category */
/** @var Product[] $products */
 ?>

<h1>category/category</h1>
<h2><?=  Html::encode($category->name)?></h2>

<div class="container">
    <div class="row">
        <?php foreach ($products as $product) : ?>
            <div class="col-sm-3">
                <div class="product-tile">
                    <h5><?= Html::encode($product->name) ?></h5>
                    <p><?= Html::encode($product->price) ?> руб.</p>
                    <?= Html::a('Купить',
                        ['cart/add', 'product_id' => $product->id],
                        ['data-product-id' => $product->id, 'class' => 'btn-buy']
                    )?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
