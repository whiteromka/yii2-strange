<?php

namespace app\patterns\generative\factoryMethod;

abstract class Blacksmith
{
    abstract public function makeSword(): ISword;
}