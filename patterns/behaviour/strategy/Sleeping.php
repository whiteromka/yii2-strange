<?php

namespace app\patterns\behaviour\strategy;

class Sleeping implements Activity
{
    public function doActivity()
    {
        echo "Developer sleeping!";
    }
}