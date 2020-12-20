<?php

use app\models\User;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var User $user */
/** @var ActiveForm $form */
?>
<div> <?= $form->field($user, 'id')->hiddenInput(['disable'=>true])->label(false)?></div>
<div class="row">
    <div class="col-sm-3"> <?= $form->field($user, 'name')->textInput()?></div>
    <div class="col-sm-3"> <?= $form->field($user, 'surname')->textInput(['maxlength' => true]) ?></div>
    <div class="col-sm-3"> <?= $form->field($user, 'status')->dropDownList(User::getNamedStatuses()) ?></div>
    <div class="col-sm-3"> <?= $form->field($user, 'gender')->dropDownList(User::getNamedGenders()) ?></div>
</div>
<div class="row">
    <div class="col-sm-6"> <?= $form->field($user, 'birthday')->textInput()?></div>
</div>