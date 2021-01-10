<?php

namespace app\commands;

use app\components\fakers\PassportFaker;
use app\components\fakers\AFaker;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use app\models\Passport;
use yii\db\Exception;
use app\models\User;
use Yii;

/**
 * Class PassportController
 * @package app\commands
 */
class PassportController extends Controller
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
        $start = time();
        $usersId = $this->usersId;
        for ($i = 0; $i < count($usersId); $i++) {
            $passport = $this->faker->setUserId($usersId[$i])->create();
            $passport->save();
            echo ".";
        }
        echo PHP_EOL . $i;
        $end = time();
        echo PHP_EOL . 'time = ' . ($end - $start);

    }

    /**
     * Create and add passport in DB (use batchInsert)
     *
     * @throws Exception
     */
    public function actionBatchInsert() : void
    {
        $start = time();
        $rows = [];
        $usersId = $this->usersId;
        for ($i = 0; $i < count($usersId); $i++) {
            $passport = $this->faker->setUserId($usersId[$i])->createAsArray();
            $rows[] = $passport;
            echo ".";
        }
        $attributes = ['user_id', 'number', 'code', 'country', 'city', 'address'];
        echo PHP_EOL . Yii::$app->db->createCommand()->batchInsert(Passport::tableName(), $attributes, $rows)->execute();
        $end = time();
        echo PHP_EOL . 'time = ' . ($end - $start);
    }
}