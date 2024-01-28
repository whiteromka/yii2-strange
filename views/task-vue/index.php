<?php

use app\widgets\vue\VueWidget;
use yii\web\View;

/** @var View $this */
?>


<div class="container-fluid">
    <div class="row">
        <?= VueWidget::widget([
            'component' => 'hello-component',
            'props' => ['msg' => 'This is message from php! Yeah!!!!!!!!']
        ]); ?>
    </div>
</div>
