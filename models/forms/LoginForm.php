<?php

namespace app\models\forms;

use app\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;

class LoginForm extends Model
{
    /** @var string */
    public $email;

    /** @var string */
    public $password;

    /** @var bool */
    public $remember_me;
    
    /** @var string - first error for login() */
    public $loginError;

    public function rules()
    {
        return [
            ['email', 'email'],
            [['password', 'email'], 'required'],
            ['remember_me', 'integer'],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function login(): bool
    {
        /** @var User $user */
        $user = User::findOne(['email' => $this->email]);
        if (!$user || !$user->checkPassword($this->password)) {
            $this->addError('email', 'Неверный email или пароль');
            $this->addError('password', 'Неверный email или пароль');
            $this->loginError = 'Неверный email или пароль';
            return false;
        }
        return Yii::$app->user->login($user);
    }
}