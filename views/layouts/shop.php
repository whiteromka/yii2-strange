<?php

use app\assets\LteAsset;
use app\modules\shop\components\widgets\MenuWidget;
use dmstr\widgets\Alert;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$sidebarCollapse = Yii::$app->session->get('sidebar-collapse');

if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\AppAsset::register($this);
}

dmstr\web\AdminLteAsset::register($this);
LteAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini <?= $sidebarCollapse ? 'sidebar-collapse' : '' ?>">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render('header.php', ['directoryAsset' => $directoryAsset]) ?>

    <?= $this->render('left.php', ['directoryAsset' => $directoryAsset]) ?>

    <div class="content-wrapper">
        <section class="content">
            <?= Alert::widget() ?>

            <div class="shop-default-index">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1>Shop</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-lg-2">
                            <?= MenuWidget::widget()?>
                        </div>
                        <div class="col-sm-9 col-lg-10">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
        </div>
        Created by <a href="http://www.sozdanie-saitov-kostroma.ru/">Belov Roman</a>
    </footer>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

