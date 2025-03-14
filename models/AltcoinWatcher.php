<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "altcoin_watcher".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $altcoin_id
 * @property float|null $wish_price - Цена при которой оповестить пользователя
 * @property float|null price_at_conclusion - Текущая цена при которой пользователь сделал ставку
 * @property integer $expectation - Ожидания
 *
 * @property Altcoin $altcoin
 */
class AltcoinWatcher extends \yii\db\ActiveRecord
{
    const EXPECTATION_UP = 1;
    const EXPECTATION_DOWN = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'altcoin_watcher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'altcoin_id'], 'integer'],
            [['wish_price', 'price_at_conclusion'], 'number'],
            [['altcoin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altcoin::class, 'targetAttribute' => ['altcoin_id' => 'id']],
            [['expectation'], 'integer']
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
            'altcoin_id' => 'Altcoin ID',
            'wish_price' => 'Wish price',
            'price_at_conclusion' => 'Price at conclusion'
        ];
    }

    /**
     * Gets query for [[Altcoin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAltcoin()
    {
        return $this->hasOne(Altcoin::class, ['id' => 'altcoin_id']);
    }

    /**
     * @return void
     */
    public function calculateExpectation(): void
    {
        $expectationIsUp = $this->wish_price > $this->price_at_conclusion;
        $this->expectation = $expectationIsUp ? self::EXPECTATION_UP : self::EXPECTATION_DOWN;
    }

}
