<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class TaskVueController extends Controller
{
    /** {@inheritdoc} */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}