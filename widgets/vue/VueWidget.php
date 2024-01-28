<?php

namespace app\widgets\vue;

use app\assets\VueAsset;
use yii\helpers\Html;

class VueWidget extends VueBaseWidget
{
    public function init()
    {
        parent::init();
        VueAsset::register($this->view);
    }

    public function run()
    {
        parent::run();
        echo Html::tag(
            'div',
            Html::tag($this->component, '', $this->props),
            ['id' => $this->getVueId()]
        );

        $this->registerJs();
    }
}
