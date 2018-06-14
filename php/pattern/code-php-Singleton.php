<?php
class Singleton
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
            echo 'new';
            return static::$instance;
        }
        echo 'old';
        return static::$instance;
    }
}

$singleton = Singleton::getInstance(); // new
$singleton = Singleton::getInstance(); // old
$singleton = Singleton::getInstance(); // old