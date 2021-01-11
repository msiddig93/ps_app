<?php
namespace App\Model;

class VendorModel extends Model
{
    function __construct()
    {
        $this->setTable("vendor");
    }

    public function load( $filter = null )
    {
        return $this->query("SELECT 
                                        vendor.*
                                      FROM 
                                vendor
                            WHERE  1=1
                            ".$filter."
                ");
    }

    public function profile( $id )
    {
        return $this->query("SELECT 
                                        vendor.*
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