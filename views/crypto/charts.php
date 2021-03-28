<?php

use app\assets\CryptoChartsAsset;
use yii\web\View;

/** @var View $this */
/** @var array $altcoins */

CryptoChartsAsset::register($this) ?>

<div class="container-fluid">
    <h3>Charts</h3>
    <div class="board">
        <ul class="nav nav-tabs">
        <?php foreach ($altcoins as $altcoin => $course) : ?>
            <li class="<?= $altcoin == 'btc' ? 'active' : '' ?>">
                <a href="#<?= $altcoin ?>" class="toUpper js-altcoin"
                   data-toggle="tab" data-altcoin="<?= $altcoin ?>">
                    <?= $altcoin ?>
                </a>
            </li>
        <?php endforeach;?>
        </ul>

        <div class="tab-content">
            <?php foreach ($altcoins as $altcoin => $course) : ?>
                <div class="tab-pane fade <?= $altcoin == 'btc' ? 'in active' : '' ?>" id="<?= $altcoin?>">
                    <h3 class="toUpper t-a-c"><?= $altcoin?>: &nbsp; <b><?=  number_format($course, 2, ',', ' ') ?> $</b></h3>
                    <div class="chartdiv" id="chartdiv-<?= $altcoin?>">
                        <div class="chartdiv-loading">
                            Loading ...
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>