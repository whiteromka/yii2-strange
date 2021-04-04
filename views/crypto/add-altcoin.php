<?php

use app\assets\AddAltcoinAsset;
use app\models\Altcoin;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var Altcoin $altcoin */
/** @var Altcoin[] $altcoins */

AddAltcoinAsset::register($this);
?>

<div class="container-fluid">
    <h3>Альтконы</h3>
    <p>Добавте альткойны интересные вам (система будет отлеживать их автоматически, добавленные альткойны
        будут доступны и в других разделах сайта)</p>
    <?php $form = ActiveForm::begin(['method' => 'POST', 'action' => ['/crypto/add-altcoin']])?>
    <div class="row">
        <div class="col-sm-4 col-lg-2">
            <?= $form->field($altcoin, 'name')->textInput(['placeholder' => "BTC"]) ?>
        </div>
        <div class="col-sm-4 col-lg-2">
            <?= $form->field($altcoin, 'full_name')->textInput(['placeholder' => "Bitcoin"]) ?>
        </div>
        <div class="col-sm-4 col-lg-2">
            <?= $form->field($altcoin, 'start_unixtime')->textInput(['placeholder' => "1452680400"]) ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'style'=> 'margin-top:24px']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>


    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Отслеживаемые альтконы</h3>

            <div class="box-tools pull-right"></div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th>ID Альткойна</th>
                        <th>Название</th>
                        <th>Текущий курс ($)</th>
                        <th>Название полностью</th>
                        <th>Статус</th>
                        <th>Инфо метки</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($altcoins as $alt): ?>
                        <tr>
                            <td><?= $alt->id ?></td>
                            <td><?= $alt->name ?></td>
                            <th><span id="<?= strtoupper($alt->name) ?>">Loading ...</span></th>
                            <td><?= $alt->full_name ?></td>
                            <td><span class="label label-default">default</span></td>
                            <td>
                                <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="box-footer clearfix"></div>
    </div>



</div>