<?php

use app\models\forms\LoginForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var View $this */
/** @var LoginForm $loginForm */
?>

<div class="col-md-6 col-md-offset-3 p-t-120">
    <div class="login-logo">
        <a href="#"><b>Авторизация</b></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Вход в личный кабинет</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form->field($loginForm, 'email')->label(false)->textInput(['placeholder' => 'Email']) ?>

        <?= $form->field($loginForm, 'password')->label(false)->passwordInput(['placeholder' => 'Password']) ?>

        <div class="row">
            <?php /*
            <div class="col-xs-8">
                <?= $form->field($loginForm, 'remember_me')->checkbox() ?>
            </div>
            */ ?>
            <div class="col-xs-4">
                <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <br>
        <p>Еще не зарегистрировались? <a href="<?= Url::to(['auth/register'])?>">Регистрироваться тут</a></p>
</div>