<?php

namespace app\modules\shop\components\widgets;

use app\models\shop\Category;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public function run()
    {
        $menu = Category::find()->where('pid is null')->all();
        return $this->render('menu', ['menu' => $menu] );
    }
}