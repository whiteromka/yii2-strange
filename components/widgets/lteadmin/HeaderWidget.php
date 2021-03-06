<?php

namespace app\components\widgets\lteadmin;

use yii\base\Widget;

class HeaderWidget extends Widget
{
    /** @var string */
    public $directoryAsset;

    public function run()
    {
        return $this->render('header', ['directoryAsset' => $this->directoryAsset]);
    }
}