<?php

namespace app\controllers;

use yii\db\StaleObjectException;
use app\models\Passport;
use yii\web\Controller;
use yii\base\Exception;
use yii\web\Response;
use app\models\User;
use Throwable;
use Yii;

class AjaxController extends  Controller
{
    /**
     * @param int $userId
     * @return array|null
     */
    public function actionGetData(int $userId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        /** @var User $user */
        $user = User::find()->with('passport')->where(['id' => $userId])->one();
        $view = $this->renderPartial('modal-edit/edit', ['user' => $user]);
        return $view;
    }

    /**
     * @return array
     */
    public function actionEditData() : array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $request = Yii::$app->request->post();
            $user = (new User())->dataSave($request);
            $passport = (new Passport())->dataSave($request);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return ['success' => false, 'error'=> $e->getMessage()];
        }
        return ['success' => true, 'user'=> $user, 'passport' => $passport];
    }

    /**
     * @param int $passportId
     * @return array
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionRemovePassport(int $passportId) : array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        /** @var Passport $passport */
        $passport = Passport::find()->where(['id' => $passportId])->one();
        $user = $passport->user;
        if ($passport->delete()) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'user' => $user, 'error' => 'Операция удаления не была произведена'];
        }
    }
}