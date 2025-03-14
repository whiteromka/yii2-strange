<?php

use yii\web\View;

/** @var View $this */
/** @var Passport|null $passport */
/** @var array|null $weather */

$fact = $weather['fact'] ?? null;
$weatherSuccess = $weather['success'] ?? null;
$weatherError = $weather['error'] ?? null;
?>

<div>
<?php if ($passport) : ?>

    <?php if (!$weather) : ?>
        <a href="#" class="btn btn-success js-btn-get-weather" data-passport-id="<?= $passport->id ?>">Запросить данные</a>
    <?php endif ;?>

    <?php if ($weatherSuccess) : ?>
        <div>
            <span><b><?= $fact['season']?></b></span> <br>
            <img width="100px" src="<?= $fact['icon']?>">
            <h4> Температура : <b><?= $fact['temp']?></b>, ощущается как <b><?= $fact['feels_like']?></b></h4>
            <h4> Ветер : <b><?= $fact['wind_speed']?></b> м\с, направление  <b><?= $fact['wind_dir']?></b></h4>
            <h4> Давление : <b><?= $fact['pressure_mm']?></b> </h4>
        </div>
    <?php else : ?>
        <div>
            <h5><?= $weatherError ?></h5>
        </div>
    <?php endif ;?>

<?php else : ?>
    <p>Невозможно запросить данные о погоде т.к. неизвестен город пользователя. Нужно прейти в раздел "пасспорт",
        добавить пасспорт. В поле город ввести реально существующий город в РФ.</p>
<?php endif ?>
</div>