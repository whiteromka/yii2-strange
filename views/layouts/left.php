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

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Users',  'url' => ['/user/filter']],
                   [
                        'label' => 'Altcoins',
                        #'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Add coin',  'icon' => '-', 'url' => ['/crypto/add-altcoin']],
                            ['label' => 'Rates',  'icon' => '-', 'url' => ['/crypto/rates']],
                            ['label' => 'Charts', 'icon' => '-', 'url' => ['/crypto/charts']],
                        ],
                    ],
                    ['label' => 'TaskManager',  'url' => ['/task/index']],
                    [
                        'label' => 'Some tools',
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
