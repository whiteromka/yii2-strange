<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
?>

<div class="site-index">
    <div class="jumbotron">
        <p><a class="btn btn btn-success m-width-200" href="<?= Url::to(['user/filter'])?>">Users Filter</a></p>
        <p><a class="btn btn btn-primary m-width-200" href="<?= Url::to(['crypto/rates'])?>">Crypto</a></p>
    </div>
</div>
