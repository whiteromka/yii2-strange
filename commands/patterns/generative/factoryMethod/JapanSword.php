<?php

namespace app\commands\patterns\generative\factoryMethod;

class JapanSword implements ISword
{
    function takeDamage()
    {
        return 10;
    }
}