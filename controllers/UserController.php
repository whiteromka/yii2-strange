<?php

namespace app\controllers;

use app\models\search\UserFilter;
use Yii;
use app\models\search\UserSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Page with user filters
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionFilter()
    {
        $userFilter = new UserFilter();
        $dataProvider = $userFilter->search(Yii::$app->request->queryParams);
        return $this->render('filter/filter', [
            'userFilter' => $userFilter,
            'dataProvider' => $dataProvider,
        ]);
    }
}
