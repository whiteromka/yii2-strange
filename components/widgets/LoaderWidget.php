<?php

namespace app\components\widgets;

use yii\base\Widget;

class LoaderWidget extends  Widget
{
    public function run()
    {
        return $this->render('loader');
    }
}