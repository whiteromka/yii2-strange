<?php

namespace app\controllers;

use app\models\Task;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class TaskController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return array
     */
    public function actionGetTasks()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        return Task::find()->select(['id','name', 'hours', 'status'])
            ->orderBy('status ASC')->asArray()->all();
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $task = new Task();
        $task->name = $post['name'] ?? null;
        $task->hours = $post['hours'] ?? 1;
        $task->status = $post['status'] ?? false;
        if ($task->save()) {
            return ['success' => true, 'id' => $task->id];
        }
        return ['success' => false, 'error' => $task->saveError];
    }

    /**
     * @return array
     */
    public function actionChange(): array
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        /** @var Task $task */
        $task = Task::findOne(['id' => $post['id']]);
        $task->name = $post['name'];
        $task->hours = $post['hours'];
        $task->status = $post['status'];
        if ($task->save()) {
            return ['success' => true, 'id' => $task->id];
        }
        return ['success' => false, 'error' => $task->saveError];
    }

    /**
     * @param int $id
     * @return array
     */
    public function actionDelete(int $id): array
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $result = (bool)Task::deleteAll(['id' => $id]);
        return ['success' => $result];
    }
}