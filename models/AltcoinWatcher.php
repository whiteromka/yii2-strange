<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "altcoin_watcher".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $altcoin_id
 * @property float|null $price Ставка при которой оповестить пользователя
 *
 * @property Altcoin $altcoin
 */
class AltcoinWatcher extends \yii\db\ActiveRecord
{
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
            [['price'], 'number'],
            [['altcoin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Altcoin::class, 'targetAttribute' => ['altcoin_id' => 'id']],
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
            'price' => 'Price',
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
}
