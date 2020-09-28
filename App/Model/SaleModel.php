<?php
namespace App\Model;

use App;

class SaleModel extends Model
{
    function __construct()
    {
        $this->setTable("sale_order");
    }

    public function load( $filter = null )
    {
        return $this->query("
                                SELECT sale_order.*,emp.FULLNAME,customer.cust_name FROM `sale_order`,emp,customer
                                WHERE emp.ID = sale_order.created_by
                                AND customer.id = sale_order.customer_id
                                ".$filter."
                                ORDER BY sale_order.id DESC
                ");
    }

    public function findInvo( $id )
    {
        return $this->query("SELECT 
                                        INVOICS.*,
                                        EMP.FULLNAME
                                      FROM 
                                INVOICS ,EMP
                            WHERE  INVOICS.EMP_ID = EMP.ID
                            AND INVOICS.BRANSH_ID = ".App::$BranshID."
                            AND INVOICS.ID = ?
                ",[$id],true);
    }

    public function LastItem( $filter = null )
    {
        return $this->query("SELECT 
                                        sale_order_details.*,
                                        product_name 
                                      FROM 
                                sale_order_details , product
                                WHERE product.id = sale_order_details.product_id
                                ORDER BY sale_order_details.id DESC",$filter,true);
    }

    public function loadItem( $filter = null )
    {
        return $this->query("SELECT 
                                        sale_order_details.*,
                                        product_name 
                                      FROM 
                                sale_order_details , product
                                WHERE product.id = sale_order_details.product_id
                                ".$filter."
                ");
    }

    public function loadEditItem( $filter = array() )
    {
        return $this->query("SELECT 
                                        sale_order_details.*
                                      FROM 
                                sale_order_details 
                                WHERE sale_order_details.product_id = ?
                                AND sale_order_id = ?
                                ",$filter,true
        );
    }

    public function CheckProductInOrder( $filter = array() )
    {
        return $this->query("SELECT 
                                        sale_order_details.*
                                      FROM 
                                sale_order_details 
                                WHERE sale_order_details.sale_order_id = ?
                                AND sale_order_details.product_id != ?
                                ",$filter
        );
    }

    public function TOTAL_AMOUNT( $filter = array() )
    {
        return $this->query("SELECT 
                                        SUM( LAST_PRICE * QTE) AS TOTAL
                                      FROM 
                                INVOIC_DETIALS 
                                WHERE INVO_ID = ?
                                ",$filter,true
        );
    }

    public function TestInsuranceStatus( $filter = array() )
    {
        return $this->query("SELECT 
                                        DELAY_COMPANY.*
                                      FROM 
                                DELAY_COMPANY 
                                WHERE DELAY_COMPANY.ITEM_ID = ?
                                AND INVO_ID = ?
                                ",$filter,true
        );
    }

    public function GetItemIvo($id = array()){
        return $this->query("
                                 SELECT  MAX(ITEMS.ID) as ID,
                                        MAX(PURECHES_PRICE) as PURECHES_PRICE ,
                                        MAX(SALE_PRICE) as SALE_PRICE, 
                                        SUM(QTE) as QTE,
                                        MIN(EX_DATE) as EX_DATE,
                                        MAX(UNIT) as UNIT,
                                        ITEMS.COMMERCAL_NAME
                                      FROM 
                                STOCK
                                INNER JOIN ITEMS
                                ON ITEMS.ID = STOCK.ITEM_ID
                                WHERE  ITEMS.ID = ?
                                AND STOCK.BRANSH_ID = ?
                                GROUP BY ITEMS.COMMERCAL_NAME
                                ORDER BY ID DESC
                ",$id ,true);
    }

    public function CovertItems($id = array()){
        return $this->query("
                                     SELECT  
                                          COVERT_ITEMS.*
                                     FROM COVERT_ITEMS
                                    WHERE  COMPANY_ID = ?
                                    AND ITEM_ID = ?
                ",$id ,true);
    }

    public function LoadStockItem($id = array()){
        return $this->query("
                                        SELECT * FROM STOCK
                                        WHERE ITEM_ID = ?
                                        AND QTE > 0
                                        AND EX_DATE > '".date('d-M-Y')."'
                                        AND BRANSH_ID = ". App::$BranshID."

                ",$id );
    }

    public function loadDelayCompany($id = array()){
        return $this->query("
                                        SELECT 
                                                DELAY_COMPANY.* ,
                                                ITEMS.COMMERCAL_NAME 
                                        FROM DELAY_COMPANY ,ITEMS
                                        WHERE DELAY_COMPANY.ITEM_ID = ITEMS.ID
                                        AND COMPANY_ID = ?

                ",$id );
    }

}