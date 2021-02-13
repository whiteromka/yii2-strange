<?php

namespace app\commands;

use app\components\fakers\EstateFaker;
use app\controllers\TController;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use app\models\Estate;
use yii\db\Exception;
use app\models\User;
use Yii;

/**
 * Class EstateController
 * @package app\commands
 */
class EstateController extends Controller
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
        $usersId = User::find()->select('id')->adult()->asArray()->column();
        $count = (int)(count($usersId) * 0.3);
        $keys = [];
        for ($i = 0; $i < 5; $i++) {
            $keys = ArrayHelper::merge($keys,  array_rand($usersId, $count));
        }
        $usersIdWhoWillHasEstate = [];
        foreach ($keys as $key) {
            $usersIdWhoWillHasEstate[] = $usersId[$key];
        }
        $this->usersId = $usersIdWhoWillHasEstate;
        return $this;
    }

    /**
     * Create and add estate in DB (use ActiveRecord)
     */
    public function actionGenerate() : void
    {
        $start = time();
        $usersId = $this->usersId;
        for ($i = 0; $i < count($usersId); $i++) {
            $estate = $this->faker->setUserId($usersId[$i])->create();
            $estate->save();
            echo ".";
        }
        echo PHP_EOL . $i;
        $end = time();
        echo PHP_EOL . 'time = ' . ($end - $start);

    }

    /**
     * Create and add estate in DB (use batchInsert)
     *
     * @throws Exception
     */
    public function actionBatchInsert() : void
    {
        $start = time();
        $rows = [];
        $usersId = $this->usersId;

        for ($i = 0; $i < count($usersId); $i++) {
            $estate = $this->faker->setUserId($usersId[$i])->createAsArray();
            $rows[] = $estate;
            echo ".";
        }
        $attributes = ['user_id', 'type', 'name', 'cost'];
        echo PHP_EOL . Yii::$app->db->createCommand()->batchInsert(Estate::tableName(), $attributes, $rows)->execute();
        $end = time();
        echo PHP_EOL . 'time = ' . ($end - $start);
    }
}