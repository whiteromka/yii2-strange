<?php

use app\assets\UserFilterAsset;
use app\components\widgets\LoaderWidget;
use app\models\search\UserFilter;
use app\assets\AjaxButtonsAsset;
use app\assets\MaskInputAsset;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model UserFilter */
/* @var $form yii\widgets\ActiveForm */

MaskInputAsset::register($this);
AjaxButtonsAsset::register($this);
UserFilterAsset::register($this);

$get = Yii::$app->request->get();
?>

<div class="user-form">
    <h3>Фильтры</h3>

    <?php $form = ActiveForm::begin([
        'method' => 'GET',
        'options' => ['data-pjax' => true],
    ]); ?>
    <div class="row">
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'status')->checkboxList(User::getNamedStatuses()) ?></div>
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'gender')->checkboxList(User::getNamedGenders()) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-3 col-md-3"> <?= $form->field($model, 'birthday')->textInput([
            'class' => 'form-control js-mask-date', 'placeholder' => 'YYYY-mm-dd'])?>
        </div>
        <div class="col-sm-6 col-md-6">
            <?php
            echo '<label class="control-label">День рождения от ... и до ...</label>';
            echo DatePicker::widget([
                'name' => "UserFilter[from_date]",
                'value' => ArrayHelper::getValue($get, 'UserFilter.from_date'),
                'type' => DatePicker::TYPE_RANGE,
                'name2' => "UserFilter[to_date]",
                'value2' => ArrayHelper::getValue($get, 'UserFilter.to_date'),
                'separator' => 'до',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Сортировка по полю</label>
                <?php $selected = ArrayHelper::getValue($get, 'sort')?>
                <?= Html::dropDownList('sort', $selected, User::getNamedSortItems(), ['class' => 'form-control'])?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-md-3"> <?= $form->field($model, 'exist_passport')->checkboxList(['Без', 'С']) ?></div>
        <div class="col-sm-4 col-md-3"> <?= $form->field($model, 'passport_country')->textInput() ?></div>
        <div class="col-sm-4 col-md-3"> <?= $form->field($model, 'passport_city')->textInput() ?></div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success ajax-bnt js-ajax-bnt">
            Применить фильтры
            <?= LoaderWidget::widget()?>
        </button>
        <a class="btn btn-warning ajax-bnt js-ajax-bnt" href="<?= Url::to(['/user/filter'])?>">
            Сбросить фильтры
            <?= LoaderWidget::widget()?>
        </a>
    </div>

    <?php ActiveForm::end(); ?>
    <hr>
    <br>
</div>
