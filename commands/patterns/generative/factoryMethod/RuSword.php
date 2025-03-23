<?php

namespace app\commands\patterns\generative\factoryMethod;

class RuSword implements ISword
{
    function takeDamage()
    {
        return 123;
    }
}