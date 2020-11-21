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
 * @property string|null $birthday
 * @property string|null $birthday_date_time
 * @property int|null $unix_birthday
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property string $fullName
 */
class User extends \yii\db\ActiveRecord
{
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
            [['birthday', 'birthday_date_time', 'created_at', 'updated_at'], 'safe'],
            [['unix_birthday', 'gender'], 'integer'],
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
            'name' => 'Name',
            'surname' => 'Surname',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
            'birthday_date_time' => 'Birth Date Time',
            'unix_birthday' => 'Unix Birthday',
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
}
