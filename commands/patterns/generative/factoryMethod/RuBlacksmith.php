<?php

namespace app\commands\patterns\generative\factoryMethod;

class RuBlacksmith extends Blacksmith
{
    public function makeSword(): ISword
    {
       return new RuSword();
    }
}