<?php

use app\components\others\Price;
use yii\web\View;

/** @var View $this */
/** @var string $altcoinName */
/** @var array $altcoinItem */
?>

<div class="col-sm-3 col-lg-2">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $altcoinName?></h3>
        </div>
        <div class="box-body">
            <ul>
                <?php foreach ($altcoinItem as $name => $price) : ?>
                    <li class="altcoin">
                        <b><?= number_format($price, 2, '.', ' ')?></b>
                        <b><?= strtolower($name)?></b>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>