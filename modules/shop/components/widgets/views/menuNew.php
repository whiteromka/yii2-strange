<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var array $menu */
/** @var int|null $activeCategoryId */

?>
<h2>Меню</h2>
<ul class="menu">
    <?php /** @var \app\models\shop\Category $menuItem */
    foreach ($menu as $menuItem) : ?>
        <?php
        $subCategories = null;
        if ($subCategories = $menuItem->subCategories) :?>
            <li class="<?= $class = $menuItem->id == $activeCategoryId ? 'active' : ''?>">
                <a href="#"><?= $menuItem->name ?></a>
            </li>
        <?php else: ?>
            <li class="<?= $class = $menuItem->id == $activeCategoryId ? 'active' : ''?>">
                <?= Html::a($menuItem->name, ['category', 'catId' => $menuItem->id]) ?>
            </li>
        <?php endif; ?>

        <?php /** Второй уровень вложенности меню  */
        if ($subCategories) : ?>
            <ul class="menu-submenu">
                <?php /** @var \app\models\shop\Category $submenuItem */
                foreach ($subCategories as $submenuItem) : ?>
                    <li class="<?= $class = $submenuItem->id == $activeCategoryId ? 'active' : ''?>">
                        <?= Html::a($submenuItem->name, ['category', 'catId' => $submenuItem->id]) ?> </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endforeach; ?>
</ul>
