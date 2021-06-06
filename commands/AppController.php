<?php

namespace app\commands;

use yii\base\InvalidRouteException;
use yii\console\Controller;
use Yii;
use yii\console\Exception;

/**
 * Class AppController
 * @package app\commands
 */
class AppController extends Controller
{
    /**
     * @throws InvalidRouteException
     * @throws Exception
     */
    public function actionFillDb()
    {
        $commands = [
            'city/batch-insert',
            'user/batch-insert',
            'passport/batch-insert',
            'estate/batch-insert',
            'crypto/fill',
            'shop/fill',
        ];
        foreach ($commands as $command) {
            Yii::$app->runAction($command);
        }
        echo PHP_EOL . 'done!';
    }
}