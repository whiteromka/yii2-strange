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
            <div class="panel panel-default user js-data-user" data-user-id="<?= $user->id?>">
                <a class="btn-edit js-btn-edit" href="#" data-user-id="<?= $user->id?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-sm-12">
                            <p><?= Html::encode($user->fullName)?></p>
                        </div>
                        <div class="col-md-4"><?= Html::encode($user->birthday)?></div>
                        <div class="col-md-4"> <b><?= Html::encode($user->getNameGender())?></b>  (<?= Html::encode($user->fullAge)?>)  </div>
                        <div class="col-md-4">
                             <span class="label my-label <?= $user->status ? 'label-success' : 'label-warning';?>">
                                <?= $user->status ? 'Active' : 'Not Active';?>
                            </span>
                        </div>
                    </div>
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