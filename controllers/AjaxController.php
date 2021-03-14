<?php

namespace app\controllers;

use app\components\api\YandexWeather;
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
     * Update user on the tile
     *
     * @param int $userId
     * @return array
     */
    public function actionUpdateDataInTile(int $userId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            $user = User::find()->where(['id' => $userId])->with('passport')->one();
            $view = $this->renderPartial('/user/filter/_user', ['user' => $user]);
            return ['success' => true, 'view' => $view];
        } catch (\Exception $e) {
            return ['success' => false, 'view' => null, 'error' => 'Данные не обновлены... ' . $e->getMessage()];
        }
    }

    /**
     * Get data (user and passport) for modal window
     *
     * @param int $userId
     * @return array|null
     */
    public function actionGetDataForModal(int $userId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        /** @var User $user */
        $user = User::find()->with('passport', 'estate')->where(['id' => $userId])->one();
        return $this->renderPartial('modal-edit/edit', ['user' => $user]);
    }

    /**
     * Save data
     *
     * @return array
     */
    public function actionDataSave() : array
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
     * Remove passport
     *
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
        }
        return ['success' => false, 'user' => $user, 'error' => 'Операция удаления не была произведена'];
    }

    /**
     * Get weather by passport (city)
     *
     * @param int $passportId
     * @return mixed
     */
    public function actionGetWeather(int $passportId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $passport = Passport::find()->where(['id' => $passportId])->one();
        $weather = $passport ? (new YandexWeather())->getByPassport($passport) : null;
        return $this->renderPartial('modal-edit/_weather', ['weather' => $weather, 'passport' => $passport]);
    }

    /**
     * Return tasks for Vue js
     *
     * @return array
     */
    public function actionGetTasks()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            ['name' => 'Сесть', 'status' => false],
            ['name' => 'Начать', 'status' => false],
            ['name' => 'Разобраться', 'status' => false],
            ['name' => 'Сделать', 'status' => false],
        ];
    }
}