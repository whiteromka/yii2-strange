<?php

use app\models\Altcoin;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var Altcoin $altcoin */
/** @var Altcoin[] $altcoins */

?>

<div class="container-fluid">
    <h3>Альтконы</h3>
    <p>Добавте альткойны за которыми нужно следить</p>
    <?php $form = ActiveForm::begin(['method' => 'POST', 'action' => ['/crypto/add-altcoin']])?>
    <div class="row">
        <div class="col-sm-5 col-lg-2">
            <?= $form->field($altcoin, 'name')->textInput(['placeholder' => "BTC"]) ?>
        </div>
        <div class="col-sm-5 col-lg-2">
            <?= $form->field($altcoin, 'full_name')->textInput(['placeholder' => "Bitcoin"]) ?>
        </div>
        <div class="col-sm-2">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'style'=> 'margin-top:24px']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>

    <ul>
        <?php foreach ($altcoins as $alt): ?>
            <li><?= $alt->name?></li>
        <?php endforeach; ?>
    </ul>
</div>