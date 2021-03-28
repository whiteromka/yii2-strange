<?php

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var ActiveDataProvider $dataProvider  */
?>

<h3>Пользователи <span class="badge"><?= $dataProvider->totalCount?></span></h3>
<div class="row">
    <?php
    /** @var User $user */
    foreach ($dataProvider->getModels() as $user) : ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <?= $this->render('_user', ['user' => $user])?>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <?= LinkPager::widget(['pagination' => $dataProvider->pagination])?>
</div>