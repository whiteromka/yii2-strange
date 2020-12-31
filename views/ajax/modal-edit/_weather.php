<?php

use yii\web\View;

/** @var View $this */
/** @var array $weather */

$fact = $weather['fact']; ?>

<?php if($weather['success']) : ?>
<div>
    <span><b><?= $fact['season']?></b></span> <br>
    <img width="100px" src="<?= $fact['icon']?>">
    <h4> Температура : <b><?= $fact['temp']?></b>, ощущается как <b><?= $fact['feels_like']?></b></h4>
    <h4> Ветер : <b><?= $fact['wind_speed']?></b> м\с, направление  <b><?= $fact['wind_dir']?></b></h4>
    <h4> Давление : <b><?= $fact['pressure_mm']?></b> </h4>
</div>
<?php else : ?>
<div>
    <h5><?= $weather['error'] ?></h5>
</div>
<?php endif ;?>
