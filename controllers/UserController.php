<?php

namespace app\controllers;

use app\models\search\UserFilter;
use app\models\search\UserSearch;
use Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\User;
use Yii;

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
              'access' => [
                  'class' => AccessControl::class,
                  'only' => ['profile'],
                  'rules' => [
                      [
                          'actions' => ['profile'],
                          'allow' => true,
                          'roles' => ['@'],
                      ],
                  ],
              ]
          ];
      }


    /**
     * Page with user filters
     *
     * @return mixed
     * @throws Exception
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

    /**
     * Page user profile
     *
     * @return string
     */
    public function actionProfile()
    {
        return $this->render('profile', [
            'user' => Yii::$app->user->identity
        ]);
    }

    /** *********** BELOW ONLY CRUD (GENERATED WITH GII) ********************* */

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
