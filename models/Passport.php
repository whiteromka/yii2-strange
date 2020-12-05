<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "passport".
 *
 * @property int $id
 * @property int|null $user_id Связь с таблицей user
 * @property int|null $number
 * @property int|null $code
 * @property string|null $country
 * @property string|null $city
 * @property string|null $address
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class Passport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'passport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'number', 'code'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['country', 'city', 'address'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'number' => 'Number',
            'code' => 'Code',
            'country' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
