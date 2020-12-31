<?php

use app\models\User;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var User $user */
?>

<?php /** Wrap for js(Ajax) message */?>
<div class="js-paste-message"></div>

<?php if ($user):?>
    <?php $form = ActiveForm::begin(['method' => 'POST', 'action'=>'', 'id' => 'user-edit'])?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab-user" data-toggle="tab">Пользователь</a>
                            </li>
                            <li><a href="#tab-passport" data-toggle="tab">Пасспорт</a></li>
                            <li><a href="#tab-weather" data-toggle="tab">Погода в городе</a></li>
                        </ul>
                    </div>
                    <div class="panel-body m-h-250">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-user">
                                <?= $this->render('_edit_user', ['form' => $form, 'user' => $user])?>
                            </div>
                            <div class="tab-pane fade" id="tab-passport">
                                <?= $this->render('_edit_passport', ['form' => $form, 'user' => $user])?>
                            </div>
                            <div class="tab-pane js-modal-tab-wrap-weather fade" id="tab-weather">
                                <?= $this->render('_weather_empty', ['user' => $user])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-success js-btn-send-user-data" type="submit">Применить</button>
        <button type="button" class="btn btn-warning js-btn-close-modal" data-dismiss="modal">Закрыть</button>
    <?php ActiveForm::end(); ?>
<?php else:?>
    <h2 class="text-danger">Что то пошло не так. Нет такого пользователя!</h2>
<?php endif;?>
