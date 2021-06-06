<?php


namespace app\components\creators;

use app\models\shop\Category;

class CategoryCreator
{
    public function fill()
    {
        $names = ['Компьютерное железо', 'Столы', 'Кресла'];
        foreach ($names as $name) {
            $category = new Category();
            $category->name = $name;
            $category->save();

            if ($category->name == 'Компьютерное железо') {
                $subs = ['Видеокарты', 'Процессоры'];
                foreach ($subs as $subName) {
                    $subCategory = new Category();
                    $subCategory->pid = $category->id;
                    $subCategory->name = $subName;
                    $subCategory->save();
                }
            }
        }
    }
}