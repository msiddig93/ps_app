<?php

namespace App;
 
class Config
{
    private static $_instance;
    public static $settings = [];

    public function __construct($config_file)
    {
        self::$settings = include($config_file);
    }

    public static function getInstance($config_file)
    {
        if( self::$_instance === null )
        {
            self::$_instance = new Config($config_file) ;
        }

        return self::$_instance;
    }

    public function get($key)
    {
        if( isset(self::$settings[$key]))
        {
            return self::$settings[$key];
        }

        return null;
    }
}