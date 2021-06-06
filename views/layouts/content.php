<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

/** @var string $content */

?>
<div class="content-wrapper">
    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
   Created by <a href="http://www.sozdanie-saitov-kostroma.ru/">Belov Roman</a>
</footer>