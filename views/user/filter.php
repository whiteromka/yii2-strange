<?php

use app\models\search\UserFilter;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\LinkPager;

/** @var View $this */
/** @var UserFilter $userFilter */
/** @var ActiveDataProvider $dataProvider */
?>

<div class="container">
    <div class="row">
        <?php
        /** @var User $user */
        foreach ($dataProvider->getModels() as $user) : ?>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><?= Html::encode($user->fullName)?></h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <span><b><?= Html::encode($user->gender ? 'Male' : 'Female')?></b></span>
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

    <div class="row">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination])?>
    </div>
</div>