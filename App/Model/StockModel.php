<?php
namespace App\Model;

class StockModel extends Model
{
    function __construct()
    {
        $this->setTable("stockroom");
    }

    public function load( $filter = null )
    {
        return $this->query("SELECT stockroom.product_id, (stockroom.sale_price) as sale_price, stockroom.purchase_price, stockroom.created_at, (stockroom.qte) as qte,product.product_name,product.sale_price,product.purchase_price,category.cat_name
                            FROM `stockroom` 
                            INNER JOIN product ON product.id = stockroom.product_id
                            INNER JOIN category ON category.id = product.category_id
                            WHERE 1
                            ".$filter."
                            GROUP BY stockroom.product_id
                ");
    }
}