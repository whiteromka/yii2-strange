<?php

use app\components\widgets\AltcoinWidget;
use app\models\CryptoRequestForm;
use yii\base\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var CryptoRequestForm $cryptoRequestForm */
/** @var array $prices */
?>

<div class="container-fluid">
    <h3>Altсoins rates</h3>
    <div class="row">
    <?php $form = ActiveForm::begin(['method' => 'GET', 'action' => ['crypto/rates']])?>
        <div class="col-sm-12 m-h-96">
            <?= $form->field($cryptoRequestForm, 'altcoinList')->checkboxList(CryptoRequestForm::getAltcoinList()) ?>
        </div>
        <div class="col-sm-12 m-h-96">
            <?= $form->field($cryptoRequestForm, 'currencyList')->checkboxList(CryptoRequestForm::getCurrencyList()) ?>
        </div>
        <div class="col-sm-3 col-lg-2">
            <?= Html::submitButton('Запросить данные', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php if ($prices['success']) :?>
            <div class="col-sm-3 col-lg-2">
                <h4>Данные на <?= date('d.m.Y H:i')?></h4>
            </div>
        <?php endif;?>
    <?php ActiveForm::end() ?>
    </div>
</div>

<?php if ($prices['success']) :?>
<div class="container-fluid block-30">

    <div class="row">
    <?php foreach ($prices['data'] as $altcoinName => $altcoinItem): ?>
        <?= AltcoinWidget::widget([
            'altcoinName' => $altcoinName,
            'altcoinItem' => $altcoinItem
        ]); ?>
    <?php endforeach; ?>
    </div>
</div>
<?php endif;?>