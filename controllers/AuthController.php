<?php

namespace app\controllers;

use app\models\forms\LoginForm;
use app\models\forms\RegisterForm;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class AuthController extends Controller
{
    /**
     * @return Response
     * @throws Exception
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $loginForm = new LoginForm();
        $post = Yii::$app->request->post();
        if ($loginForm->load($post)) {
            if ($loginForm->login()) {
                return $this->redirect(['/user/profile']);
            }
        }

        return $this->render('login', compact('loginForm'));
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $post = Yii::$app->request->post();
        $registerForm = new RegisterForm();
        if ($registerForm->load($post) && $registerForm->register()) {
            return $this->redirect(['/auth/login']);
        }
        return $this->render('register', compact('registerForm'));
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}