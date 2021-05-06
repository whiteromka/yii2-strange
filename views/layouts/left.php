<?php

use yii\web\View;

/** @var View $this */
/** @var string $directoryAsset */

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php $isGuest = Yii::$app->user->isGuest;
        echo  dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    $isGuest ? ['label' => 'Регистрация', 'icon' => 'sign-in', 'url' => ['/auth/register']] : null,
                    !$isGuest ? ['label' => 'Личный кабинет',  'icon' => 'user', 'url' => ['/user/profile']] : null,
                    $isGuest ? ['label' => 'Вход',  'icon' => 'sign-in',  'url' => ['/auth/login']] :
                        ['label' => 'Выход',  'icon' => 'sign-out',  'url' => ['/auth/logout']],
                    ['label' => 'Пользователи',  'icon' => 'users',  'url' => ['/user/filter']],
                    [
                        'label' => 'Криптовалюта',
                        'icon' => 'btc',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Добавить',  'icon' => '-', 'url' => ['/crypto/add-altcoin']],
                            ['label' => 'Курсы',  'icon' => '-', 'url' => ['/crypto/rates']],
                            ['label' => 'Графики', 'icon' => '-', 'url' => ['/crypto/charts']],
                        ],
                    ],
                    ['label' => 'Задачи',  'icon' => 'tasks',  'url' => ['/task/index']],
                    [
                        'label' => 'Инструменты',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
