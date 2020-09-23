<?php
namespace App\Model;

class ProductModel extends Model
{
    function __construct()
    {
        $this->setTable("product");
    }

    public function load( $filter = null )
    {
        return $this->query("  SELECT product.*, category.cat_name  FROM `product` 
                                        INNER JOIN category
                                        ON product.category_id = category.id
                                        WHERE 1
                            ".$filter."
                ");
    }

    public function profile( $id )
    {
        return $this->query("SELECT 
                                        product.*
                                      FROM 
                                emp 
                            WHERE emp.id = ?
                            
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

    public function show($id)
    {
        
    }
}