<?php

use app\components\others\Price;
use yii\web\View;

/** @var View $this */
/** @var string $altcoinName */
/** @var array $altcoinItem */
?>

<div class="col-sm-3">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><?= $altcoinName?></h3>
        </div>
        <div class="panel-body">
            <ul>
                <?php foreach ($altcoinItem as $name => $price) : ?>
                    <li class="altcoin"><b><?= Price::pretty($price)?></b>  <b><?= strtolower($name)?></b></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>