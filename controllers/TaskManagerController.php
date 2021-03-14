<?php

namespace app\controllers;

use yii\web\Controller;

class TaskManagerController extends Controller
{
    /**
     * Test Vue.js
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}