<?php

use app\models\search\UserFilter;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
use yii\web\View;

/** @var View $this */
/** @var UserFilter $userFilter */
/** @var ActiveDataProvider $dataProvider */
?>

<?php Pjax::begin(); ?>
<div class="container-fluid">
    <?= $this->render('_form-filter', ['model'=> $userFilter])     // filter form ?>
    <?= $this->render('_users', ['dataProvider' => $dataProvider]) // data tile (users) ?>
    <?= $this->render('/ajax/modal-edit/modal')                    // modal window ?>
</div>
<?php Pjax::end(); ?>