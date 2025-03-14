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

class AjaxController extends Controller
{
    /**
     * Update user on the tile
     *
     * @param int $userId
     */
    public function actionUpdateDataInTile(int $userId)
    {
        $user = User::find()->where(['id' => $userId])->with('passport')->one();
        $view = $this->renderPartial('/user/filter/_user', ['user' => $user]);
        return $this->asJson(['success' => true, 'view' => $view]);
    }

    /**
     * Get data (user and passport) for modal window
     *
     * @param int $userId
     * @return string
     */
    public function actionGetDataForModal(int $userId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::find()->with('passport', 'estate')->where(['id' => $userId])->one();
        return $this->renderPartial('modal-edit/edit', ['user' => $user]);
    }

    /**
     * Save data
     *
     * @return Response
     */
    public function actionDataSave()
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $request = Yii::$app->request->post();
            $user = (new User())->dataSave($request);
            $passport = (new Passport())->dataSave($request);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return $this->asJson([
                'success' => false,
                'error'=> $e->getMessage()
            ]);
        }
        return $this->asJson([
            'success' => true,
            'user'=> $user,
            'passport' => $passport
        ]);
    }

    /**
     * Remove passport
     *
     * @return Response
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionRemovePassport()
    {
        $passportId = Yii::$app->request->post('passportId');
        /** @var Passport $passport */
        $passport = Passport::find()->where(['id' => $passportId])->one();
        $user = $passport->user;
        $passport->delete();
        return $this->asJson(['success' => true, 'user' => $user]);
    }

    /**
     * Get weather by passport (city)
     *
     * @return mixed
     */
    public function actionGetWeather()
    {
        $passportId = Yii::$app->request->post('passportId');
        Yii::$app->response->format = Response::FORMAT_JSON;
        /** @var Passport $passport */
        $passport = Passport::find()->where(['id' => $passportId])->one();
        $weather = $passport ? (new YandexWeather())->getByPassport($passport) : null;

        return $this->renderPartial('modal-edit/_weather', [
            'weather' => $weather,
            'passport' => $passport
        ]);
    }
}