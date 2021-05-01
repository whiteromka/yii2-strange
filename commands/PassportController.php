<?php

namespace app\commands;

use app\components\fakers\PassportFaker;
use app\components\fakers\AFaker;
use app\models\Passport;
use yii\db\Exception;
use app\models\User;
use Yii;

/**
 * Class PassportController
 * @package app\commands
 */
class PassportController extends BaseController
{
    /** @var AFaker */
    private $faker;

    /** @var array - user's ID who need passport */
    private $usersId;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->faker = new PassportFaker();
        $this->usersId = User::find()->select('id')->adult()->asArray()->column();
    }

    /**
     * Create and add passport in DB (use ActiveRecord)
     */
    public function actionGenerate() : void
    {
        $usersId = $this->usersId;
        for ($i = 0; $i < count($usersId); $i++) {
            $passport = $this->faker->setUserId($usersId[$i])->create();
            $this->checkSave($passport->save());
        }
        $this->setSuccessCount($i);
        $this->showActionInfo();
    }

    /**
     * Create and add passport in DB (use batchInsert)
     *
     * @throws Exception
     */
    public function actionBatchInsert() : void
    {
        $rows = [];
        $usersId = $this->usersId;
        for ($i = 0; $i < count($usersId); $i++) {
            $passport = $this->faker->setUserId($usersId[$i])->createAsArray();
            $rows[] = $passport;
            $this->checkSave(true);
        }
        $attributes = ['user_id', 'number', 'code', 'country', 'city', 'address'];
        $successCount = Yii::$app->db->createCommand()->batchInsert(Passport::tableName(), $attributes, $rows)->execute();
        $this->setSuccessCount($successCount);
        $this->showActionInfo();
    }
}