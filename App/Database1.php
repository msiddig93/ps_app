<?php
namespace App;
use \PDO;

class Database
{
    private static $db_host ;
    private static $db_user ;
    private static $db_name ;
    private static $db_pass;
    private static $tns; 
    private static $connStr;
    private static $pdo;

    public function __construct($db_name = "orcl",$db_host = "localhost",$db_user = "pharmasy",$db_pass = 'pharmasy')
    {
        self::$db_host = $db_host;
        self::$db_name = $db_name;
        self::$db_user = $db_user;
        self::$db_pass = $db_pass;

        self::$tns = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".self::$db_host.")(PORT = 1521)))(CONNECT_DATA=(SID=".self::$db_name.")))"; 
        self::$connStr = "oci:dbname=". self::$tns.";charset=AR8MSWIN1256";
    }

    public function getPDO()
    {     
        try
		{
            if(self::$pdo == null)
            {
                $pdo = new PDO(self::$connStr,self::$db_user,self::$db_pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                self::$pdo = $pdo;
            }

            return self::$pdo;
		}
	catch(PDOException $e)
		{
			echo "Filed To Connected ".$e->getMessage();
		}
    }

    public function query($statment , $one = false,$class = null)
    {
        $q = $this->getPDO()->query($statment);
        $fetch = true;
        if (
              strpos(strtoupper($statment), "INSERT") || 
              strpos(strtoupper($statment), "UPDATE") || 
              strpos(strtoupper($statment), "DELETE") 

           ) 
        {
            $fetch = false;
            return $q;
        }

        if ($class === null ) 
        {
            $q->setFetchMode(PDO::FETCH_OBJ);
        }
        else
        {
            $q->setFetchMode(PDO::FETCH_CLASS , $class);
        }

        if ($fetch) {
            if ($one) {
                $data = $q->fetch();
            } else {
                $data = $q->fetchAll();
            }
        }else{
            $data = $q;
        }

        return $data;
    }

    public function prepare($statment , $attributes , $one = false,$class = null)
    {
        var_dump($statment);
        die();
        $stmt = $this->getPDO()->prepare($statment);
        $q = $stmt->execute($attributes);

        if (
              strpos(strtoupper($statment), "INSERT") || 
              strpos(strtoupper($statment), "UPDATE") || 
              strpos(strtoupper($statment), "DELETE")

           ) 
        {
            return $q;
        }

        if ($class === null ) 
        {
            $stmt->setFetchMode(PDO::FETCH_OBJ);
        }
        else
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS , $class);
        }

        if ($one) 
        {
            $data = $stmt->fetch();
        }
        else
        {
            $data = $stmt->fetchAll();
        }

        return $data;
    }
}