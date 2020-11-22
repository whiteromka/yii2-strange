<?php

use app\models\search\UserFilter;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\web\View;

/** @var View $this */
/** @var UserFilter $userFilter */
/** @var ActiveDataProvider $dataProvider */
?>

<?php Pjax::begin(['timeout' => 5000]); ?>
<div class="container">

    <h1 class="p-b-40">Фильтрация пользователей</h1>

    <?= $this->render('_form-filter', ['model'=> $userFilter]); ?>
    <?= $this->render('_users', ['dataProvider' => $dataProvider])?>

    <div class="row">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination])?>
    </div>
</div>
<?php Pjax::end(); ?>