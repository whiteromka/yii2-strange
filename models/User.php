<?php

namespace app\models;

use app\models\query\UserQuery;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property int $fullAge
 * @property Passport $passport
 * @property Estate $estate
 */
class User extends ActiveRecord
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
     * @return UserQuery|ActiveQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getPassport()
    {
        return $this->hasOne(Passport::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getEstate()
    {
        return $this->hasMany(Estate::class, ['user_id' => 'id']);
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
     * @return int
     */
    public function getFullAge() : int
    {
        $arrDate = explode('-', $this->birthday);
        $y = $arrDate[0];
        $m = $arrDate[1];
        $d = $arrDate[2];
        if($m > date('m') || $m == date('m') && $d > date('d')) {
            return (date('Y') - $y - 1);
        }
        return (date('Y') - $y);
    }

    /**
     * @return array
     */
    public static function getNamedGenders() : array
    {
        return [self::GENDER_FEMALE => 'Ж', self::GENDER_MALE => 'М'];
    }

    /**
     * @return array
     */
    public static function getNamedStatuses() : array
    {
        return [self::STATUS_NOT_ACTIVE => 'Нет', self::STATUS_ACTIVE => 'Да'];
    }

    /**
     * @return array
     */
    public static function getNamedSortItems() : array
    {
        return [
            'id' => 'ID (прямая)',
            '-id' => 'ID (обратная)',
            'name'=>'Имя (прямая)',
            '-name'=>'Имя (обратная)',
            'birthday' => 'Дата рождения (прямая)',
            '-birthday' => 'Дата рождения (обратная)',
        ];
    }

    /**
     * @param array $request
     * @return User
     * @throws Exception
     */
    public function dataSave(array $request) : User
    {
        $userData = ArrayHelper::getValue($request, 'User');
        /** @var User $user */
        $user = self::find()->where(['id' => $userData['id']])->one();
        $user->load($userData, '');
        if (!$user->save()) {
            $error = $user->firstErrors;
            throw new Exception('Пользователь не сохранился! ' . $error[array_key_first($error)]);
        }
        return $user;
    }
}