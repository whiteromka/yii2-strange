<?php

namespace app\commands;

use app\components\fakers\EstateFaker;
use app\controllers\TController;
use yii\helpers\ArrayHelper;
use app\models\Estate;
use yii\db\Exception;
use app\models\User;
use Yii;

/**
 * Class EstateController
 * @package app\commands
 */
class EstateController extends BaseController
{
    /** @var EstateFaker */
    private $faker;

    /** @var array - adult user's */
    public $usersId;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->faker = new EstateFaker();
        $this->setUsersId();
    }

    /**
     * @return TController
     */
    public function setUsersId() : self
    {
        $maxCountEstateForUser = 5;
        $usersId = User::find()->select('id')->adult()->asArray()->column();
        $count = (int)(count($usersId) * 0.3);
        $keys = [];
        for ($i = 0; $i < $maxCountEstateForUser; $i++) {
            $keys = ArrayHelper::merge($keys,  array_rand($usersId, $count));
        }
        foreach ($keys as $key) {
            $this->usersId[] = $usersId[$key];
        }
        return $this;
    }

    /**
     * Create and add estate in DB (use ActiveRecord)
     */
    public function actionGenerate() : void
    {
        $usersId = $this->usersId;
        for ($i = 0; $i < count($usersId); $i++) {
            $estate = $this->faker->setUserId($usersId[$i])->create();
            $this->checkSave($estate->save());
        }
        $this->showActionInfo(true, true);
    }

    /**
     * Create and add estate in DB (use batchInsert)
     *
     * @throws Exception
     */
    public function actionBatchInsert() : void
    {
        $rows = [];
        $usersId = $this->usersId;

        for ($i = 0; $i < count($usersId); $i++) {
            $estate = $this->faker->setUserId($usersId[$i])->createAsArray();
            $rows[] = $estate;
            $this->checkSave(true);
        }
        $attributes = ['user_id', 'type', 'name', 'cost'];
        $added = Yii::$app->db->createCommand()->batchInsert(Estate::tableName(), $attributes, $rows)->execute();
        $this->setSuccessCount($added);
        $this->showActionInfo();
    }
}