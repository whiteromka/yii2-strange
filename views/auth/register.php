<?php

use app\assets\AuthAsset;
use app\models\forms\RegisterForm;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/** @var View $this */
/** @var RegisterForm $registerForm */
?>

<div class="col-md-6 col-md-offset-3 p-t-120">
    <div class="login-logo">
        <a href="#"><b>Регистрация</b></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Регистрация нового пользователя</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'method' => 'POST']); ?>

        <?= $form->field($registerForm, 'name')->label(false)->textInput(['placeholder' => 'Имя']) ?>
        <?= $form->field($registerForm, 'surname')->label(false)->textInput(['placeholder' => 'Фамилия']) ?>
        <?= $form->field($registerForm, 'gender')->label(false)->dropDownList(
                User::getNamedGenders(),
                ['placeholder' => 'Пол']
        )?>

        <div class="form-group">
            <?= DatePicker::widget([
                    'name' => 'RegisterForm[birthday]',
                    'options' => ['placeholder' =>  'Дата рождения (yyyy-mm-dd)'],
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>
        </div>

        <?= $form->field($registerForm, 'email')->label(false)->textInput(['placeholder' => 'Email']) ?>
        <?= $form->field($registerForm, 'password')->label(false)->passwordInput(['placeholder' => 'Пароль']) ?>
        <?= $form->field($registerForm, 'password_repeat')->label(false)->passwordInput(['placeholder' => 'Повтор пароля']) ?>

        <div class="row">

            <div class="col-xs-4">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <br>
        <p>Если вы зарегистрированы, <a href="<?= Url::to(['auth/login'])?>">авторизуйтесь тут</a></p>
    </div>
