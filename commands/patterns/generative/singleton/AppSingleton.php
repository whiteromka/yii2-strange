<?php

namespace app\commands\patterns\generative\singleton;

class AppSingleton
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        echo "X " . microtime() . 'X' . PHP_EOL;
    }

    private function __clone() {}

    public function __wakeup() {}
}