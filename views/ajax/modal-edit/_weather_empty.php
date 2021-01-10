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
        <p>Невозможно запросить данные о погоде т.к. неизвестен город пользователя. Нужно прейти в раздел "пасспорт",
            добавить пасспорт. В поле город ввести реально существующий город в РФ.</p>
    <?php endif ?>
</div>