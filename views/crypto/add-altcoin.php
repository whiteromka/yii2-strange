<?php

use app\assets\AddAltcoinAsset;
use app\models\Altcoin;
use app\models\AltcoinWatcher;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var Altcoin $altcoin */
/** @var Altcoin[] $altcoins */
/** @var AltcoinWatcher $altcoinWatcher */

AddAltcoinAsset::register($this);
?>

<div class="container-fluid">
    <h3>Альтконы</h3>
    <p>Добавьте альткойны интересные вам. Система будет отлеживать их автоматически, добавленные альткойны
        будут доступны и в других разделах сайта)</p>
    <?php $form = ActiveForm::begin(['method' => 'POST', 'action' => ['/crypto/add-altcoin']])?>
    <div class="row">
        <div class="col-sm-4 col-lg-2">
            <?= $form->field($altcoin, 'name')->label('Имя (тикер)')
                ->textInput(['placeholder' => "BTC", 'required'=>1]) ?>
        </div>
        <div class="col-sm-4 col-lg-2">
            <?= $form->field($altcoin, 'full_name')->textInput(['placeholder' => "Bitcoin"]) ?>
        </div>
        <div class="col-sm-4 col-lg-2">
            <?= $form->field($altcoin, 'start_unixtime')
                ->textInput(['placeholder' => "1452680400", 'required' => 1, 'type' => 'number']) ?>
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
                            <th><span id="<?= strtoupper($alt->name) ?>" class="js-price">Loading ...</span></th>
                            <td><?= $alt->full_name ?></td>
                            <td>
                                <?php if ($alt->altcoinWatchers) :?>
                                    <span class="label label-info">watching</span>
                                <?php else: ?>
                                    <span class="label label-default">default</span>
                                <?php endif; ?>
                            </td>
                            <td style="min-width: 220px">
                                <button type="button"  data-toggle="modal" data-target="#myModal"
                                    data-altcoin-id="<?= $alt->id?>" data-altcoin-name="<?= $alt->name?>"
                                    class="js-watcher-modal btn btn-info btn-sm"><i class="fa fa-plus"></i>
                                </button>
                                <?php /** @var AltcoinWatcher $watcher */
                                foreach ($alt->altcoinWatchers as $watcher): ?>
                                    <span class="watcher" data-watcher-id="<?= $watcher->id?>">
                                        <?= $watcher->wish_price?>
                                        <span class="js-delete-watcher fa fa-close"> </span>
                                    </span>
                                <?php endforeach;?>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Отслеживание <span id="js-watcher-name-placeholder"></span></h4>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'altcoinWatcherForm',
                'method' => 'post',
                'action' => '/crypto/add-watcher'
            ]); ?>
                <div class="modal-body">
                    <p>Установите цену по достижении которой следует уведомить вас</p>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <?= $form->field($altcoinWatcher, 'altcoin_id')->label(false)
                                ->hiddenInput(['id' => 'js-watcher-id-placeholder']) ?>

                            <?= $form->field($altcoinWatcher, 'price_at_conclusion')->label(false)
                                ->hiddenInput(['id' => 'js-watcher-current-price-placeholder']) ?>

                            <?= $form->field($altcoinWatcher, 'wish_price')->label("Цена")
                                ->textInput(['type' => 'number', 'id' => 'js-watcher-price-placeholder', 'step'=>'0.2']) ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default js-modal-close" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary js-send-modal">Установить</button>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
