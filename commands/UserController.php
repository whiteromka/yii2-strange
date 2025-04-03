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

    /** php yii user/generate 10
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

    /** php yii user/batch-insert 1000
     * Create and add users in DB (use batchInsert)
     *
     * @param int $count
     */
    public function actionBatchInsert(int $count = 10000): void
    {
        $added = 0;
        while ($added < $count) {
            for ($i = 0; $i < 10000; $i++) {
                $user = $this->userFaker->createAsArray();
                $rows[] = $user;
            }
            $added += $this->updateBatch($rows);
        }
        echo PHP_EOL . 'Total Added - ' . $added;
    }

    private function updateBatch(array $rows): int
    {
        $attributes = ['name', 'surname', 'gender', 'status', 'birthday'];
        return Yii::$app->db->createCommand()->batchInsert(User::tableName(), $attributes, $rows)->execute();
    }
}