<?php

use app\assets\MenuAsset;
use yii\web\View;

/** @var View $this */
/** @var array $menu */

MenuAsset::register($this);
?>

<ul id="accordion" class="accordion">
    <?php foreach ($menu as $item): ?>
        <?= $this->render('_menu', ['item' => $item])?>
    <?php endforeach;?>
</ul>
