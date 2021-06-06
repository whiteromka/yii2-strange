<?php

namespace app\models\shop;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "card_item".
 *
 * @property int $id
 * @property int|null $card_id
 * @property int|null $product_id
 * @property int|null $count
 * @property int|null $price
 * @property int|null $discount
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Card $card
 * @property Product $product
 */
class CardItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_id', 'product_id', 'count', 'price', 'discount'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Card::class, 'targetAttribute' => ['card_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'product_id' => 'Product ID',
            'count' => 'Count',
            'price' => 'Price',
            'discount' => 'Discount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Card]].
     *
     * @return ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(Card::class, ['id' => 'card_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
