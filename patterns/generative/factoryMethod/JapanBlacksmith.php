<?php

namespace app\patterns\generative\factoryMethod;

class JapanBlacksmith extends Blacksmith
{
    public function makeSword(): ISword
    {
       return new JapanSword();
    }
}