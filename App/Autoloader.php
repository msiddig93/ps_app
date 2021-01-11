<?php

namespace App;

class Autoloader
{
    static function autoload($class)
    {
        // var_dump($class);
        $class = str_replace('\\','/',$class);
        include(ROOT.'/'.$class.'.php');
    }

    static function register()
    {
        spl_autoload_register(array(__CLASS__,'autoload'));
    }
}