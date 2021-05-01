<?php

use app\assets\CryptoChartsAsset;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var array $altcoins */
/** @var array $prices */

CryptoChartsAsset::register($this) ?>

<div class="container-fluid">
    <h3>Charts</h3>
    <div class="board">
        <ul class="nav nav-tabs">
        <?php foreach ($altcoins as $id => $altcoin) : ?>
            <li class="<?= $altcoin == 'btc' ? 'active' : '' ?>">
                <a href="#<?= $altcoin ?>" class="toUpper js-altcoin"
                   data-toggle="tab" data-altcoin="<?= Html::encode($altcoin) ?>">
                    <?= $altcoin ?>
                </a>
            </li>
        <?php endforeach;?>
        </ul>

        <div class="tab-content">
            <?php foreach ($altcoins as $id => $altcoin) : ?>
                <div class="tab-pane fade <?= $altcoin == 'btc' ? 'in active' : '' ?>" id="<?= Html::encode($altcoin)?>">
                      <h3 class="toUpper t-a-c">
                          <?= $altcoin ?>: &nbsp;
                          <b><?= number_format($prices[$altcoin], 2, ',', ' ') ?> $</b>
                      </h3>
                    <div class="chartdiv" id="chartdiv-<?= Html::encode($altcoin)?>">
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