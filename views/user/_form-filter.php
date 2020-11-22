<?php

use app\components\widgets\LoaderWidget;
use app\models\search\UserFilter;
use app\assets\AjaxButtonsAsset;
use app\assets\MaskInputAsset;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model UserFilter */
/* @var $form yii\widgets\ActiveForm */

MaskInputAsset::register($this);
AjaxButtonsAsset::register($this);
?>

<div class="user-form">
    <h3>Фильтры</h3>

    <?php $form = ActiveForm::begin([
        'method' => 'GET',
        'options' => ['data-pjax' => true],
    ]); ?>
    <div class="row">
        <div class="col-md-4"> <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-4"> <?= $form->field($model, 'gender')->checkboxList(User::getNamedGenders()) ?></div>
    </div>

    <div class="row">
        <div class="col-md-4"> <?= $form->field($model, 'birthday')->textInput([
                'class' => 'form-control js-mask-date', 'placeholder' => 'YYYY-mm-dd'
            ]) ?>
        </div>
        <div class="col-md-8">
            <?php
            $get = Yii::$app->request->get();
            echo '<label class="control-label">День рождения от ... и до ...</label>';
            echo DatePicker::widget([
                'name' => "UserFilter[from_date]",
                'value' => ArrayHelper::getValue($get, 'UserFilter.from_date'),
                'type' => DatePicker::TYPE_RANGE,
                'name2' => "UserFilter[to_date]",
                'value2' => ArrayHelper::getValue($get, 'UserFilter.to_date'),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success ajax-bnt js-ajax-bnt">
            Apply filters
            <?= LoaderWidget::widget()?>
        </button>
        <a class="btn btn-warning ajax-bnt js-ajax-bnt" href="<?= \yii\helpers\Url::to(['/user/filter'])?>">
            Clear filters
            <?= LoaderWidget::widget()?>
        </a>
    </div>

    <?php ActiveForm::end(); ?>
    <hr>
    <br>
</div>
