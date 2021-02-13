<?php

use app\models\Estate;
use app\models\User;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $view */
/** @var User $user */
/** @var ActiveForm $form */
?>


<?php
/** @var Estate[] $estate */
if ($estates = $user->estate) : ?>
    <?php $disabled = ['disabled' => true]; ?>
    <?php /** @var Estate $estate */
    foreach ($estates as $estate) :?>
    <?= $form->field($estate, 'id')->hiddenInput($disabled)->label(false) ?>
    <?= $form->field($estate, 'user_id')->hiddenInput(['disabled' => true, 'value' => $user->id])->label(false) ?>
    <div class="row">
        <div class="col-sm-4"> <?= $form->field($estate, 'type')->dropDownList(Estate::getTypes(), $disabled) ?></div>
        <div class="col-sm-4"> <?= $form->field($estate, 'name')->textInput($disabled) ?></div>
        <div class="col-sm-4"> <?= $form->field($estate, 'cost')->textInput($disabled) ?></div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>У этого пользователя нет имущества</p>
<?php endif; ?>
