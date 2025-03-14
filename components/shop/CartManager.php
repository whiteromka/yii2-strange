<?php

namespace app\components\shop;

use app\models\shop\Cart;
use app\models\shop\CartItem;
use app\models\shop\Product;
use yii\base\Exception;
use app\models\User;
use Yii;

class CartManager
{
    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = Yii::$app->user->identity;
    }

    /**
     * @param int $productId
     * @param int $count
     * @return bool
     * @throws Exception
     */
    public function add(int $productId, int $count = 1): bool
    {
        if (!$this->user) {
            throw new  Exception('Пользователь не авторизован, невозможно добавить товар в корзину');
        }
        if (!$product = Product::findOne($productId)) {
            throw new Exception('Не могу найти продукт по ID');
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->tryAdd($product, $count);
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
        return false;
    }

    /**
     * @param Product $product
     * @param int $count
     */
    protected function tryAdd(Product $product, int $count)
    {
        $cart = $this->getActiveCartOrCreateNew();
        $cartItem = new CartItem([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'count' => $count,
            'price' => $product->price
        ]);
        $cartItem->save();
        /** ToDo написать calculateTotals() для пересчета стоимости корзины */
        // $cart->calculateTotals();
    }

    /**
     * @return Cart
     */
    public function getActiveCartOrCreateNew(): Cart
    {
        $cart = Cart::find()->where(['user_id' => $this->user->id])->one();
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $this->user->id;
            $cart->save(false);
        }
        return $cart;
    }
}