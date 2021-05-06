<?php

namespace app\models\forms;

use app\models\User;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RegisterForm extends Model
{
    /** @var string */
    public $name;

    /** @var string */
    public $surname;

    /** @var int */
    public $gender;

    /** @var string */
    public $birthday;

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var int  */
    public $status = 1;

    /** @var string */
    public $password_repeat;
    
    /** @var string - first error for register() */
    public $registerError;

    public function rules()
    {
        return [
            [['password', 'password_repeat', 'name', 'email'], 'required'],
            [['gender', 'status'], 'integer'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            [['name', 'surname', 'birthday', 'email', 'password', 'password_repeat'], 'string', 'max' => 255],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function register(): bool
    {
        $user = new User();
        $user->load(ArrayHelper::toArray($this), '');
        $user->password_hash = User::generatePasswordHash($this->password);
        if (!$user->save()) {
            $this->registerError = $user->saveError;
            return false;
        }
        return true;
    }
}