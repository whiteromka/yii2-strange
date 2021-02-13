<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "estate".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $type
 * @property string $name
 * @property int $cost
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class Estate extends ActiveRecord
{
    const TYPE_THING = 0;
    const TYPE_CAR = 1;
    const TYPE_REAL_ESTATE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'cost'], 'integer'],
            [['name', 'cost'], 'required'],
            [['created_at', 'updated_at', 'user_id'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'type' => 'Тип',
            'name' => 'Наименование',
            'cost' => 'Стоимость ($)',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_THING => 'Вещь',
            self::TYPE_CAR => 'Машина',
            self::TYPE_REAL_ESTATE => 'Недвижимость'
        ];
    }

    /**
     * @return array
     */
    public static function getThings()
    {
        return [
            'Кот',
            'Собака',
            'Sneakers reebok',
            'Sneakers nike',
            'TV',
            'Macbook',
            'Macbook pro',
            'PC',
            'Велик',
        ];
    }

    /**
     * @return array
     */
    public static function getCars()
    {
        return [
            'ЗАЗ',
            'ВАЗ',
            'Reno',
            'Kia',
            'Ford',
            'Honda',
            'Mazda',
            'Lexus',
            'Bmw',
            'Mercedes'
        ];
    }

    /**
     * @return array
     */
    public static function getRealEstates()
    {
        return [
            'Cheap apartment',
            'Apartment',
            'Good apartment',
            'Apartment in EURO',
            'House',
            'House in EURO',
            'Villa in EURO',
        ];
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        return [
            self::getThings(),
            self::getCars(),
            self::getRealEstates()
        ];
    }

    /**
     * @return array
     */
    public static function getTypeCostRate() : array
    {
        return [30, 100, 800];
    }
}
