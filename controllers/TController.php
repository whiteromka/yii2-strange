<?php

namespace app\controllers;

use app\models\base\Passport;
use Faker\Factory;
use Yii;
use yii\web\Controller;

class TController extends Controller
{
    public function actionIndex()
    {
        $f = Factory::create();
        $unixTime = $f->numberBetween(315532800, 1605899933);


        $d = gmdate("Y-m-d H:i:s",$unixTime);
        debug($d);  die;

    }

}
