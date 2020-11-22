<?php

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/** @var ActiveDataProvider $dataProvider  */
?>

<h3>Пользователи <span class="badge"><?= $dataProvider->totalCount?></span> </h3>
<div class="row">
    <?php
    /** @var User $user */
    foreach ($dataProvider->getModels() as $user) : ?>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><?= Html::encode($user->fullName)?>
                        <span class="pull-right">
                            <span class="label my-label <?= $user->status ? 'label-success' : 'label-warning';?>">
                                <?= $user->status ? 'Active' : 'Not Active';?>
                            </span>
                        </span>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <span><b><?= Html::encode($user->getNameGender())?></b></span>
                        </div>
                        <div class="col-sm-6">
                            <span class="pull-right"><?= Html::encode($user->birthday)?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>