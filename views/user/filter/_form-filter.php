<?php

use app\assets\UserFilterAsset;
use app\components\widgets\LoaderWidget;
use app\models\search\UserFilter;
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

UserFilterAsset::register($this);

$get = Yii::$app->request->get();
?>

<h1 class="p-b-40">Фильтрация пользователей</h1>
<div class="user-form">
    <h3>Фильтры</h3>
    <?php $form = ActiveForm::begin([
        'action' => ['filter'],
        'method' => 'GET',
        'options' => ['data-pjax' => 1],
    ]); ?>
    <div class="row">
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'status')->checkboxList(User::getNamedStatuses()) ?></div>
        <div class="col-sm-6 col-md-3"> <?= $form->field($model, 'gender')->checkboxList(User::getNamedGenders()) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-6 form-group">
            <?php
            echo '<label class="control-labels">День рождения от ... и до ...</label>';
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
    </div>

    <div class="row">
        <div class="col-sm-4 col-md-3"> <?= $form->field($model, 'exist_passport')->checkboxList(['Без', 'С']) ?></div>
        <div class="col-sm-4 col-md-3"> <?= $form->field($model, 'passport_country')->textInput() ?></div>
        <div class="col-sm-4 col-md-3"> <?= $form->field($model, 'passport_city')->textInput() ?></div>
    </div>

    <hr>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-3 col-md-3">
                <label class="control-label">Сортировка по полю</label>
                <?php $selected = ArrayHelper::getValue($get, 'sort')?>
                <?= Html::dropDownList('sort', $selected, User::getNamedSortItems(), ['class' => 'form-control'])?>
            </div>
            <div class="col-sm-4 col-md-3">
                <label class="control-label">Записей на странице</label>
                <?php $selected = ArrayHelper::getValue($get, 'page_size')?>
                <?= Html::dropDownList('page_size', $selected, UserFilter::getPageSizeList(), ['class' => 'form-control'])?>
            </div>
            <div class="col-sm-6 col-md-6">
                <button type="submit" class="btn btn-success m-t-24 ajax-bnt js-ajax-bnt" >
                    Применить фильтры
                    <?= LoaderWidget::widget()?>
                </button>
                <a class="btn btn-warning ajax-bnt m-t-24" data-pjax="0"  href="<?= Url::to(['/user/filter'])?>">
                    Сбросить фильтры
                    <?= LoaderWidget::widget()?>
                </a>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <hr>
    <br>
</div>
