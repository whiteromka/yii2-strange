<?php

namespace app\models\t;

class Axe implements IWeapon
{
    public function damage()
    {
        return 10;
    }
}