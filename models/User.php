<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property integer $gender
 * @property integer $status
 * @property string|null $birthday
 * @property integer $created_at
 * @property integer|null $updated_at
 *
 * @property string $fullName
 */
class User extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;

    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['gender', 'status'], 'integer'],
            [['name', 'surname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'birthday' => 'Дата рождения',
            'gender' => 'Пол',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return string
     */
    public function getFullName() : string
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return string
     */
    public function getNameGender() : string
    {
        $genders = self::getNamedGenders();
        return $genders[$this->gender];
    }

    /**
     * @return array
     */
    public static function getNamedGenders() : array
    {
        return [self::GENDER_FEMALE => 'Женщина', self::GENDER_MALE => 'Мужчина'];
    }

    /**
     * @return array
     */
    public static function getNamedStatuses() : array
    {
        return [self::STATUS_NOT_ACTIVE => 'Not active', self::STATUS_ACTIVE => 'Active'];
    }
}
