<?php
use App\Database;
use App\Config;

class App
{
    private static $db;
    private static $_instance;
    public static $current_page = 'index';
    public static $path ;
    public static $BranshID;

    public function getPage()
    {
        return self::$current_page;
    }

    public function setPage($name)
    {
        self::$current_page = $name;
    }

    public static function getInstance()
    {
        if( self::$_instance === null )
        {
            self::$_instance = new App();
        }

        return self::$_instance;
    }
     
    public static function load()
    {
        session_start();
        include(ROOT."/App/Autoloader.php");
        \App\Autoloader::register();
    }

    public function getDB()
    {
        if( self::$db === null )
        {
            $config = Config::getInstance(ROOT.'/App/Config/config.php');
            self::$db = new Database($config->get('db_name'),$config->get('db_host'),$config->get('db_user'),$config->get('db_pass'));
        }
        return self::$db;
    }

    public function getModel($name)
    {
        $model = '\App\Model\\'.ucfirst($name).'Model';
        return new $model($this->getDB());
    }
}