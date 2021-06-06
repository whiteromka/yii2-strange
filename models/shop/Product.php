<?php

namespace app\models\shop;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property float|null $price
 * @property float|null $old_price
 * @property int|null $is_new
 * @property int|null $status
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 * @property Stock[] $stocks
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_DISABLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'is_new', 'status'], 'integer'],
            [['price', 'old_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'is_new' => 'Is New',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Stocks]].
     *
     * @return ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasOne(Stock::class, ['product_id' => 'id']);
    }
}
