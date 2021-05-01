<?php

namespace app\commands;

use app\components\fakers\UserFaker;
use yii\db\Exception;
use app\models\User;
use Yii;

/**
 * Class UserController
 * @package app\commands
 */
class UserController extends BaseController
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
        for ($i = 0; $i < $count; $i++) {
            $user = $this->userFaker->create();
            $this->checkSave($user->save());
        }
        $this->setSuccessCount($i);
        $this->showActionInfo();
    }

    /**
     * Create and add users in DB (use batchInsert)
     *
     * @param int $count
     * @throws Exception
     */
    public function actionBatchInsert(int $count = 10000) : void
    {
        $rows = [];
        for ($i = 0; $i < $count; $i++) {
            $user = $this->userFaker->createAsArray();
            $rows[] = $user;
            $this->checkSave(true);
        }
        $attributes = ['name', 'surname', 'gender', 'status', 'birthday'];
        $successCount = Yii::$app->db->createCommand()->batchInsert(User::tableName(), $attributes, $rows)->execute();
        $this->setSuccessCount($successCount);
        $this->showActionInfo();
    }
}