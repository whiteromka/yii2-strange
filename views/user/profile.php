<?php

use app\models\User;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/** @var User $user */
/** @var View $this */
?>

<h1>Профиль пользователя</h1>
<div class="col-sm-6">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($user, 'name')->textInput() ?>
    <?= $form->field($user, 'surname')->textInput() ?>
    <?= $form->field($user, 'gender')->dropDownList(User::getNamedGenders()) ?>

    <?= $form->field($user, 'status')->textInput(['placeholder' => 'Email', 'disabled' => 'disabled']) ?>
    <div class="form-group">
        <label class="control-label" for="">Дата рождения</label>
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

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>





