<?php

namespace app\commands;

use app\components\UserFaker;
use yii\console\Controller;
use yii\db\Exception;
use app\models\User;
use Yii;

class UserController extends Controller
{
    /** @var UserFaker */
    private $userFaker;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userFaker = new UserFaker();
    }

    /**
     * Create and add users in DB (use ActiveRecord)
     *
     * @param int $count
     */
    public function actionGenerate(int $count = 10000) : void
    {
        $start = time();
        for ($i = 0; $i < $count; $i++) {
            $user = $this->userFaker->create();
            $user->save();
            echo ".";
        }
        echo PHP_EOL . $i;
        $end = time();
        echo PHP_EOL . 'time = ' . ($end - $start);

    }

    /**
     * Create and add users in DB (use batchInsert)
     *
     * @param int $count
     * @throws Exception
     */
    public function actionBatchInsert(int $count = 10000) : void
    {
        $start = time();
        $rows = [];
        for ($i = 0; $i < $count; $i++) {
            $user =  $this->userFaker->createAsArray();
            $rows[] = $user;
            echo ".";
        }
        $attributes = ['name', 'surname', 'gender', 'birthday', 'birthday_date_time', 'unix_birthday'];
        echo PHP_EOL . Yii::$app->db->createCommand()->batchInsert(User::tableName(), $attributes, $rows)->execute();
        $end = time();
        echo PHP_EOL . 'time = ' . ($end - $start);
    }
}