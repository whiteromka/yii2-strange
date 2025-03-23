<?php

namespace app\commands\patterns\generative\factoryMethod;

abstract class Blacksmith
{
    abstract public function makeSword(): ISword;
}