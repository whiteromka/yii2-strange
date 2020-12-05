<?php

namespace app\components\fakers;

use yii\db\ActiveRecord;

abstract class AFaker
{
    /** @var AFaker */
    protected $faker;

    /** @var int  */
    protected $unixTimeFrom = 315532800;

    /** @var int  */
    protected $unixTimeTo = 1605899933;

    abstract function create();

    abstract function createAsArray();
}