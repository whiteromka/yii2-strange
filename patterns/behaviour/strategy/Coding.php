<?php

namespace app\patterns\behaviour\strategy;

class Coding implements Activity
{
    public function doActivity()
    {
        echo "Developer write code!";
    }
}