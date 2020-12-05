<?php

use app\models\search\UserFilter;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
use yii\web\View;

/** @var View $this */
/** @var UserFilter $userFilter */
/** @var ActiveDataProvider $dataProvider */
?>

<?php Pjax::begin(['timeout' => 5000]); ?>

<div class="container">
    <?= $this->render('_form-filter', ['model'=> $userFilter]); ?>
    <?= $this->render('_users', ['dataProvider' => $dataProvider])?>
</div>

<?php Pjax::end(); ?>