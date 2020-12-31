<?php

use app\models\User;
use yii\web\View;

/** @var View $this */
/** @var User $user */

?>

<div>
    <?php if ($user->passport) : ?>
        <a href="#" class="btn btn-success js-btn-get-weather" data-passport-id="<?= $user->passport->id?>">Запросить данные</a>
    <?php else : ?>
        <h5>Невозможно запросить данные о погоде т.к. неизвестен город пользователя</h5>
    <?php endif ?>
</div>