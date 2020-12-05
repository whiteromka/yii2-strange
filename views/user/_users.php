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
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p> <?= Html::encode($user->fullName)?>
                        <span class="pull-right">
                            <span class="label my-label <?= $user->status ? 'label-success' : 'label-warning';?>">
                                <?= $user->status ? 'Active' : 'Not Active';?>
                            </span>
                        </span>
                    </p>
                    <p>
                        <span><b><?= Html::encode($user->getNameGender())?></b>  (<?= Html::encode($user->fullAge)?>) </span>
                        <span class="pull-right"><?= Html::encode($user->birthday)?> </span>
                    </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                        <?php
                            $passport = $user->passport;
                            if ($passport): ?>
                            <span class="text-success"><b>Passport</b> </span>
                            <div class="passport">
                                <ul style="padding: 0">
                                    <li>Номер:  <?= Html::encode($passport->number)?></li>
                                    <li>Серия:  <?= Html::encode($passport->code)?></li>
                                    <li>Страна:  <?= Html::encode($passport->country)?></li>
                                    <li>Город:  <?= Html::encode($passport->city)?></li>
                                    <li>Адрес: <?= Html::encode($passport->address)?></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <span class="text-danger"><b>Have no passport</b></span>
                            <div class="passport"></div>
                        <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <?= LinkPager::widget(['pagination' => $dataProvider->pagination])?>
</div>