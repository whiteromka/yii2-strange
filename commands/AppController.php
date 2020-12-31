<?php

namespace app\commands;

use yii\base\InvalidRouteException;
use yii\console\Controller;
use Yii;

/**
 * Class AppController
 * @package app\commands
 */
class AppController extends Controller
{
    /**
     * @throws InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionFillDb()
    {
        $commands = ['city/batch-insert', 'user/batch-insert', 'passport/batch-insert'];
        foreach ($commands as $command) {
            Yii::$app->runAction($command);
        }
        echo PHP_EOL . 'done!';
    }
}