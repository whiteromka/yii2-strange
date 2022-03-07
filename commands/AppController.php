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
        echo 'Hold on tight bro! Now we fill DB.' . PHP_EOL;
        sleep(1);
        echo '3' . PHP_EOL;
        sleep(1);
        echo '2' . PHP_EOL;
        sleep(1);
        echo '1' . PHP_EOL;
        sleep(1);
        echo "!!!!!!" . PHP_EOL;

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