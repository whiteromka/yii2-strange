<?php


namespace app\components\creators;

use app\models\shop\Category;
use app\models\shop\Product;

class ProductCreator implements ICreator
{
    public function fill()
    {
        $categories = Category::find()->all();
        /** @var Category $category */
        foreach ($categories as $category) {
            if ($category->name == 'Компьютерное железо') {
                continue;
            }
            $this->careateProductsByCategory($category);
        }
    }

    /**
     * @param Category $category
     */
    public function careateProductsByCategory(Category $category): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product([
                'name' => "Продукт $i категории " . $category->name,
                'category_id' => $category->id,
                'price' => 1000 * rand(1, 10) + rand(1, 1000),
                'status' => Product::STATUS_ACTIVE
            ]);
            $product->save();
        }
    }
}