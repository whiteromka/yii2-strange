<?php

namespace app\patterns\generative\factoryMethod;

class JapanSword implements ISword
{
    function takeDamage()
    {
        return 10;
    }
}