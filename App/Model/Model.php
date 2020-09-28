<?php
namespace App\Model;
use App;
use App\Database;

class Model 
{
    protected static $db ;
    protected static $table;
    
    public function __construct(Database $db)
    {
        self::$db = $db;
    }

    public function getDB()
    {
        return \App::getInstance()->getDB();
    }

    public function getTable()
    {
        return self::$table;
    }

    public function all()
    {
        return $this->query("SELECT * FROM ".$this->getTable());
    }



    public function extract($key ,$value)
    {
        $records = $this->all();
        $array = [];

        foreach( $records as $rows )
        {
            $array[$rows->$key] = $rows->$value;
        }

        return $array;
    }

    public function extractItems($key ,$value , $filter = "" )
    {
        $id = App::$BranshID;
        $records = $this->query("
                                SELECT  MAX(ITEMS.ID) as ID,
                                        MAX(PURECHES_PRICE) as PURECHES_PRICE ,
                                        MAX(SALE_PRICE) as SALE_PRICE, 
                                        SUM(QTE) as QTE,
                                        MIN(EX_DATE) as EX_DATE,
                                        MAX(CREATED_AT) as CREATED_AT,
                                        ITEMS.COMMERCAL_NAME
                                      FROM 
                                STOCK
                                INNER JOIN ITEMS
                                ON ITEMS.ID = STOCK.ITEM_ID
                                WHERE STOCK.BRANSH_ID = {$id}
                                ".$filter."
                                GROUP BY ITEMS.COMMERCAL_NAME
                                ORDER BY ID DESC
                ");;
        $array = [];

        foreach( $records as $rows )
        {
            $array[$rows->$key] = $rows->$value;
        }

        return $array;
    }

    public function extractStock($key ,$value , $filter = "" )
    {
        $records = $this->query("
                SELECT product.id,product.product_name,stock.qte 
                FROM `stock`
                INNER JOIN product ON product.id = stock.product_id
                WHERE 1
                ");
        $array = [];

        foreach( $records as $rows )
        {
            $array[$rows->$key] = $rows->$value;
        }

        return $array;
    }

    public function setTable($table)
    {
        return self::$table = $table;
    }

    public function create($fields)
    {
        $sql_pairs = [];
        $attributes = [];

        foreach ($fields as $k => $v) {
            $sql_pairs[] = " ? ";
            $attributes[] = $v;
        }

        $sql_pairs = implode(',', $sql_pairs);
        return $this->query(" INSERT INTO {$this->getTable()} VALUES( $sql_pairs )" ,$attributes);
    }

    public function update($id ,$fields)
    {
        $sql_pairs = [];
        $attributes = [];

        foreach ($fields as $k => $v) {
            $sql_pairs[] = $k." = ? ";
            $attributes[] = $v;
        }

        $attributes[] = $id;
        $sql_pairs = implode(',', $sql_pairs);

        return $this->query(" UPDATE {$this->getTable()} SET $sql_pairs WHERE ID = ? " ,$attributes);
    }

    public function updateItem($id = "" ,$fields)
    {
        $sql_pairs = [];
        $attributes = [];

        foreach ($fields as $k => $v) {
            $sql_pairs[] = $k." = ? ";
            $attributes[] = $v;
        }

        $sql_pairs = implode(',', $sql_pairs);

        return $this->query(" UPDATE {$this->getTable()} SET $sql_pairs {$id} " ,$attributes);
    }

    public function findStock($id)
    {
        return $this->query("SELECT * FROM stock WHERE product_id = ? ",[$id] , true);
    }

    public function find($id)
    {
        return $this->query("SELECT * FROM {$this->getTable()} WHERE id = ? ",[$id] , true);
    }

    public function max()
    {
        $re = $this->query("SELECT  MAX(`id`) as id + 1 as max from {$this->getTable()} ",null,true);
        return $re->max;
    }

     public function NextID()
    {
        $id = $this->query("SELECT MAX(ID)+1 as ID FROM {$this->getTable()}",null,true);
        return isset($id->id) || $id->ID != null ? $id->ID : 1 ;
    }

    public function delete($id)
    {
        return $this->getDB()->getPDO()->exec("DELETE from {$this->getTable()} where id= {$id}");
//        return $this->query("DELETE from {$this->getTable()} where id= {$id}" );
    }

    public function deleteItem($where = "")
    {
        return $this->getDB()->getPDO()->exec("DELETE from {$this->getTable()} {$where}");
    }

    public function search($id ,$fields = null)
    {
        
    }

    public function query($statment ,$attributes = null , $one = false)
    {
        if ($attributes)
        {
            return $this->getDB()->prepare($statment ,
                                           $attributes ,
                                           $one 
                                           );
        }
        else
        {   
            return $this->getDB()->query(
                        $statment ,
                        $one ,
                        str_replace( 'Model' , 'Model' , get_class($this))
                   );
        }
    }

}
