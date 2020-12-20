<?php

use app\models\Passport;
use app\models\User;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var User $user */
?>

<?php /** @var Passport|null $passport */
if ($passport = $user->passport): ?>
    <div class="p-relative">
        <a class="btn btn-xs btn-danger btn-remove-passport js-btn-remove-passport"
           data-passport-id="<?=$passport->id?>" href="#"> Удалить пасспорт </a>
    </div>
    <div>
        <input type="hidden" name="Passport[action]" value="update">
        <?= $form->field($passport, 'id')->hiddenInput(['disable'=>true])->label(false)?>
    </div>
    <div class="row">
        <div class="col-sm-2"> <?= $form->field($passport, 'number')->textInput()?></div>
        <div class="col-sm-2"> <?= $form->field($passport, 'code')->textInput()?></div>
        <div class="col-sm-4"> <?= $form->field($passport, 'country')->textInput()?></div>
        <div class="col-sm-4"> <?= $form->field($passport, 'city')->textInput()?></div>
    </div>
    <div class="row">
        <div class="col-sm-12"> <?= $form->field($passport, 'address')->textInput()?></div>
    </div>
<?php else:?>
    <div class="js-block-have-no-passport">
        <p>У этого пользователя нет пасспорта</p>
        <a class="btn btn-primary js-btn-add-passport" href="#">Добавить пасспорт</a>
    </div>
    <div class="js-block-new-passport d-none">
        <?php $passport = new Passport() ?>
        <div>
            <input type="hidden" name="Passport[action]" value="">
            <?= $form->field($passport, 'user_id')->hiddenInput(['disable' => true, 'value' => $user->id])->label(false)?>
        </div>
        <div class="row">
            <div class="col-sm-2"> <?= $form->field($passport, 'number')->textInput()?></div>
            <div class="col-sm-2"> <?= $form->field($passport, 'code')->textInput()?></div>
            <div class="col-sm-4"> <?= $form->field($passport, 'country')->textInput()?></div>
            <div class="col-sm-4"> <?= $form->field($passport, 'city')->textInput()?></div>
        </div>
        <div class="row">
            <div class="col-sm-12"> <?= $form->field($passport, 'address')->textInput()?></div>
        </div>
    </div>
<?php endif;?>