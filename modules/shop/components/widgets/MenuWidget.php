<?php

namespace app\modules\shop\components\widgets;

use app\models\shop\Category;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public function run()
    {
        $activeCategoryId = self::getActiveCategory();
        $menu = Category::find()->where('pid is null')->with('subCategories')->all();
        return $this->render('menuNew', ['menu' => $menu, 'activeCategoryId' => $activeCategoryId] );
    }

    public static function getActiveCategory()
    {
        return \Yii::$app->request->get('catId');
    }
}