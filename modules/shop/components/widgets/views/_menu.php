<?php

use app\models\shop\Category;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var Category $item */
?>

<li>
    <?php if ($item->hasChilds()): ?>
        <div class="link">
            <?= $item->name ?>
            <i class="fa fa-chevron-down"></i>
        </div>
        <ul class="submenu">
            <?php foreach ($item->getChilds() as $subItem): ?>
                <li>
                    <?= Html::a($subItem->name, ['category', 'id'=>$subItem->id]) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <?= Html::a($item->name, ['category', 'id' => $item->id], ['class' =>'link']) ?>
    <?php endif; ?>
</li>