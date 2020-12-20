<?php

use app\assets\UserEditModalAsset;
use yii\web\View;

/** @var View $this */

UserEditModalAsset::register($this)
?>

<div class="modal fade" id="js-modal-user-edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Редактирование пользователя</h4>
            </div>
            <div class="modal-body" style="min-height: 400px">
                <div class="js-paste-message"></div>
                <div class="js-paste-content"></div>
            </div>
        </div>
    </div>
</div>
