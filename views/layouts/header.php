<?php

use app\components\widgets\lteadmin\HeaderWidget;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $content string */
/** @var string $directoryAsset */

?>

<header class="main-header">

    <?= Html::a(
        '<span class="logo-mini">Yii2</span><span class="logo-lg">Yii2-strange</span>',
        Yii::$app->homeUrl,
        ['class' => 'logo']
    ) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle js-sidebar-collapse" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <?php // echo HeaderWidget::widget(['directoryAsset' => $directoryAsset]) ?>

    </nav>
</header>
