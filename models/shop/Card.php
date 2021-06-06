<?php

namespace app\models\shop;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $total_count
 * @property int|null $total_price
 * @property int|null $total_discount
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 * @property CardItem[] $cardItems
 */
class Card extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'total_count', 'total_price', 'total_discount'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_count' => 'Total Count',
            'total_price' => 'Total Price',
            'total_discount' => 'Total Discount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[CardItems]].
     *
     * @return ActiveQuery
     */
    public function getCardItems()
    {
        return $this->hasMany(CardItem::class, ['card_id' => 'id']);
    }
}
