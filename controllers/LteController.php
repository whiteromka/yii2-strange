<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class LteController extends Controller
{
    /**
     * @return array
     */
    public function actionChangeSidebarMode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $sidebarCollapse = $session->get('sidebar-collapse') ?? false;
        $session->set('sidebar-collapse', !$sidebarCollapse);
        return ['success' => true];
    }
}