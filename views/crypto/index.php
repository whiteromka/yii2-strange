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

<div class="container">
    <h1>Crypto/index</h1>
    <div class="row">
    <?php $form = ActiveForm::begin(['method' => 'GET', 'action' => ['crypto/index']])?>
        <div class="col-sm-12 m-h-96">
            <?= $form->field($cryptoRequestForm, 'altcoinList')->checkboxList(CryptoRequestForm::getAltcoinList()) ?>
        </div>
        <div class="col-sm-12 m-h-96">
            <?= $form->field($cryptoRequestForm, 'currencyList')->checkboxList(CryptoRequestForm::getCurrencyList()) ?>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-2 pt-6">
            <?= $form->field($cryptoRequestForm, 'save')->checkbox([0 => 'Сохранить данные']) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::submitButton('Запросить данные', ['class' => 'btn btn-primary']) ?>
        </div>



    <?php ActiveForm::end() ?>
    </div>
</div>

<?php if ($prices['success']) :?>
<div class="container block-30">
    <h4>Данные на <?= date('d.m.Y H:i')?></h4>
    <div class="row">
    <?php foreach ($prices['data'] as $altcoinName => $altcoinItem): ?>
        <?= AltcoinWidget::widget([
            'altcoinName' => $altcoinName,
            'altcoinItem' => $altcoinItem
        ])?>
    <?php endforeach; ?>
    </div>
</div>
<?php endif;?>