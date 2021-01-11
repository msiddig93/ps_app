<?php
namespace App\Model;

use App;

class PurchaseModel extends Model
{
    function __construct()
    {
        $this->setTable("purchase_order");
    }

    public function load( $filter = null )
    {
        return $this->query("
                                SELECT purchase_order.*,emp.FULLNAME,vendor.vend_name FROM `purchase_order`,emp,vendor
                                WHERE emp.ID = purchase_order.created_by
                                AND vendor.id = purchase_order.vendor_id
                                ORDER BY purchase_order.id DESC
                            
                            ".$filter."
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

    public function loadItem( $filter = null )
    {
        return $this->query("SELECT 
                                        purchase_order_details.*,
                                        product_name 
                                      FROM 
                                purchase_order_details , product
                                WHERE product.id = purchase_order_details.product_id
                                ".$filter."
                ");
    }

    public function loadEditItem( $filter = array() )
    {
        return $this->query("SELECT 
                                        purchase_order_details.*
                                      FROM 
                                purchase_order_details 
                                WHERE purchase_order_details.product_id = ?
                                AND purchase_order_id = ?
                                ",$filter,true
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