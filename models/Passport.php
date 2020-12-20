<?php

namespace app\models;

use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
class Passport extends ActiveRecord
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
            'number' => 'Номер',
            'code' => 'Код',
            'country' => 'Страна',
            'city' => 'Город',
            'address' => 'Адресс',
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

    /**
     * @param array $request
     * @return Passport
     * @throws Exception
     */
    public function dataSave(array $request) : self
    {
        $passportData = ArrayHelper::getValue($request, 'Passport');
        $action = ArrayHelper::getValue($passportData, 'action');
        if (!$passportData) {
            return false;
        }
        if ($action) {
            $this->load($passportData, '');
            if (!$this->save()) {
                $error = $this->firstErrors;
                throw new Exception('Пасспорт не сохранился! ' . $error[array_key_first($error)]);
            }
        }
        return $this;
    }

}
