<?php
namespace App\Model;

class StockModel extends Model
{
    function __construct()
    {
        $this->setTable("stock");
    }

    public function load( $filter = null )
    {
        return $this->query("SELECT stock.*,product.product_name,product.sale_price,product.purchase_price,category.cat_name
                            FROM `stock` 
                            INNER JOIN product ON product.id = stock.product_id
                            INNER JOIN category ON category.id = product.category_id
                            WHERE 1
                            ".$filter."
                ");
    }

    public function show( $id )
    {
        return $this->query("SELECT 
                                        stock.*
                                      FROM 
                                      stock 
                            WHERE stock.id = ?
                            
                ", [$id] , true);
    }

    public function login($login , $pass)
    {
        $emp = $this->query("SELECT 
                                            emp.*
                                             
                                      FROM emp
                                      WHERE login = ?
                                      "
                                ,[$login]
                                ,true
        );

        if ($emp)
        {
            if ($emp->PASS == sha1($pass)){
                $_SESSION['emp'] = $emp;
                setcookie("pharmacy_app_emp_id",$emp->id, time() + 3600 ,"/");
                return true;
            }
        }else{
            return false;
        }

    }
}