<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class  SaleController extends Controller
{
    private static $Order;

    public function __construct()
    {
        parent::__construct();
        self::$Order = $this->loadModel('Sale');
    }

    public function index()
    {
        $form = new Form($_POST);

        self::$Order->setTable("product");
        $products = self::$Order->extract("id","product_name");

        self::$Order->setTable("customer");
        $customers = self::$Order->extract("id","cust_name");

        $this->render('sale/order',compact('form','products','customers'));
    }

    public function GetItemInvo()
    {
        $result = self::$Order->GetItemIvo([$_POST['id'],App::$BranshID]);
        $re = json_encode($result, JSON_PRETTY_PRINT);

        return $re;
    }

    public function CovertItems()
    {
        $result = self::$Order->CovertItems([$_POST['COMPANY_ID'],$_POST['ITEM_ID']]);
        if (!$result){
            return 0;
        }
        $re = json_encode($result, JSON_PRETTY_PRINT);

        return $re;
    }

    public function load()
    {
        $stmt = self::$Order->load();
        $re = "";
        foreach($stmt as $result):
            $re.="<tr>
                        <td>
                           ". $result->id ."
                        </td>
                        
                        <td>
                           ". $result->cust_name ."
                        </td>
                        <td>
                           ". $result->FULLNAME ."
                        </td>
                        <td style='direction: ltr;' >
                           ". $result->order_date ."
                        </td>
                        <td>
                           ". $result->total_price ." SDG
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-default'
                               href='".App::$path."sales/printBill/". $result->id ."'
                               target='_blank'
                               title='طباعة'><i class='fa fa-print'></i>
                            </a> 
                            <a class='btn btn-danger'
                                href='".App::$path."sales/printBill/". $result->id ."'
                                target='_blank'
                                title='حذف'><i class='fa fa-ban'></i>
                            </a> 
                            <a class='btn btn-primary'
                                href='#'
                                element_id='". $result->id ."'
                                onclick='ShowOrderDetails(this,event)'
                                title='التفاصيل'><i class='fa fa-info-circle'></i>
                            </a> 
                        </td>
                    </tr>";
        endforeach;
        return $re;
    }

    public function loadItem()
    {

        $stmt = self::$Order->loadItem(" AND sale_order_details.sale_order_id = ".$this->INVOIC_ID());
        
        if(empty($stmt)){
            return "<div class='alert alert-danger alert-block m-5' >لم يتم إضافة أي منتجات لهذا الامر بعد</div>";
        }

        $re = "";
        $number = 1;
        
        $totalPrice = 0.0;
        foreach($stmt as $result):
            $totalPrice = ( $result->price * $result->quantity );
            $re.="<tr>
                        <td>
                               ". $number ."
                        </td>
                        <td>
                               ". $result->product_name ."
                        </td>
                        <td>
                           ". $result->price ."
                        </td>
                        <td>
                           ". $result->quantity ."
                        </td>
                        <td>
                           % ". $result->discount ." ( {$totalPrice} )
                        </td>
                        <td>
                           ". ( $totalPrice - $totalPrice * $result->discount  / 100 )   ."
                        </td>
                        
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $result->id ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $result->id ."'
                               title='حذف'
                               onclick='DeleteElement(this ,event);' >
                                <i class='fa fa-trash-o'></i></a>
                        </td>
                    </tr>";
        endforeach;
        return $re;
    }

    public function loadAddID()
    {
        return self::$Order->NextID();
    }

    public function INVOIC_ID()
    {
        self::$Order->setTable("sale_order");
        return self::$Order->NextID();
    }

    public function search()
    {
        $filter = '';

        if (isset($_POST['FULLNAME']) && !empty($_POST['FULLNAME'])) {
            $filter .= " AND FULLNAME LIKE '%{$_POST['FULLNAME']}%' ";
        }

        if (isset($_POST['TYPE']) && !empty($_POST['TYPE'])) {
            $filter .= "AND TYPE LIKE '%{$_POST['TYPE']}%' ";
        }

        if (isset($_POST['BRANSH_ID']) && !empty($_POST['BRANSH_ID'])) {
            $filter .= "AND BRANSH_ID LIKE '%{$_POST['BRANSH_ID']}%' ";
        }

        $_SESSION['search-emp'] = $filter;

        self::$Order->setTable("INSURANCECOMM");
        $stmt = self::$Order->load($filter);
        $re = "";
        foreach($stmt as $result):
            if ( $result->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/emp/". $result->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $result->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $result->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $result->ADDRSS ."</p>
                            <p> الفرع : ". $result->NAME ."#  </p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $result->PHONE ."</p>
                            <p>". $result->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $result->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $result->ID ."'
                               title='حذف'
                               onclick='DeleteElement(this ,event);' >
                                <i class='fa fa-trash-o'></i></a>
                        </td>
                    </tr>";
            }

        endforeach;
        return $re;
    }

    public function add()
    {
        if (!empty($_POST) ) {
            $stmt = self::$Order->loadItem(" AND sale_order_details.sale_order_id = ".$this->INVOIC_ID());

            // if ($stmt){
            //     foreach($stmt as $result):
            //         $qte = $result->QTE;
            //         $result->ITEM_ID;
            //         $items = self::$Order->LoadStockItem([$result->ITEM_ID]);

            //         foreach($items as $item ){
            //             if ($qte > 0 ){

            //                 if ( $qte > $item->QTE ){
            //                     $newQte = $item->QTE - $qte ;
            //                     $qte = $qte - $item->QTE;
            //                     self::$Order->setTable("STOCK");
            //                     $params = [
            //                         'QTE' => $newQte,
            //                     ];
            //                     $rs =  self::$Order->update( $item->ID ,$params);
            //                 }else{
            //                     $newQte = $item->QTE - $qte ;
            //                     self::$Order->setTable("STOCK");
            //                     $params = [
            //                         'QTE' => $newQte,
            //                     ];
            //                     $rs =  self::$Order->update( $item->ID ,$params);
            //                     $qte = 0;
            //                 }

            //             }else{
            //                 break;
            //             }
            //         }
            //     endforeach;
            // }else{
            //     return 2;
            // }

            $params = [
                'id' => null,
                'customer_id' => $_POST['customer_id'],
                'order_date' => date("Y-m-s H:i:s"),
                'total_price' => $_POST['total_price'],
                'created_by' => $_SESSION['emp']->ID,
            ];

            self::$Order->setTable("sale_order");
            $rs = self::$Order->create($params);

            if ($rs) {
                return 1;
            } else {
                return 0;
            }

        }
    }

    public function AddItems()
    {
        if (!empty($_POST) ) {

            if ( self::$Order->loadEditItem([$_POST['product_id'],$this->INVOIC_ID()]) ){
                return 2;
            }


            $params =[
                'id' => null,
                'sale_order_id' => $_POST['sale_order_id'],
                'product_id' => $_POST['product_id'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
                'discount' => $_POST['discount'],
            ];

            self::$Order->setTable("sale_order_details");
            $rs = self::$Order->create($params);

            if ($rs) {
                return 1;
            } else {
                return 0;
            }

        }
    }

    public function EditItems()
    {
        $where = "";
        if (!empty($_POST) ) {
            $order_details = self::$Order->loadEditItem([$_POST['id'],$this->INVOIC_ID()]);
            // check the new Product if is already entered in this ane Sale Order 
            // Load Product in this order .
            $test = self::$Order->CheckProductInOrder([$_POST['sale_order_id'], $order_details->product_id ]);
            
            if ($test){
                // check if alreadu Entered throgh this loop 
                foreach($test as $order):
                    if($order->product_id == $_POST['product_id'])
                        return 2;
                endforeach;
            }


            $params =[
                'sale_order_id' => $_POST['sale_order_id'],
                'product_id' => $_POST['product_id'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
                'discount' => $_POST['discount'],
            ];

            self::$Order->setTable("sale_order_details");
            $rs = self::$Order->update($_POST['id'], $params);

           

            if ($rs) {
                return 1;
            } else {
                return 0;
            }

        }
    }

    public function edit()
    {
        if (!empty($_POST) ) {
            self::$Order->setTable("INSURANCECOMM");

            $params = [
                'NAME' => $_POST['NAME'],
                'PHONE' => $_POST['PHONE'],
                'ADDRESS' => $_POST['ADDRESS'],
                'TOP_AMOUNT' => $_POST['TOP_AMOUNT'],
                'CREATED_BY' => $_SESSION['emp']->ID,
            ];

            $rs =  self::$Order->update( $_POST['ID'] ,$params);

            if ($rs) {
                return 1;
            } else {
                return 0;
            }
        }

        $this->render('emp/add',compact('form','emps'));
    }

    public function LoadElementEdit()
    {
        $result = self::$Order->loadEditItem([$_POST['ITEM_ID'],$this->INVOIC_ID()]);
        $re = json_encode($result, JSON_PRETTY_PRINT);

        return $re;
    }

    public function TOTAL_AMOUNT()
    {
        $stmt = self::$Order->loadItem(" AND sale_order_details.sale_order_id = ".$this->INVOIC_ID());
        $totalPrice = 0;
        $lastTotalPrice = 0.0;

        

        foreach($stmt as $result):
            $totalPrice = ( $result->price * $result->quantity );
            $lastTotalPrice += $totalPrice - $totalPrice * $result->discount  / 100 ;
        endforeach;

        return $lastTotalPrice > 1 ? $lastTotalPrice : 0.00;
    }

    public function TestInsuranceStatus(){
        $result = self::$Order->TestInsuranceStatus([$_POST['ITEM_ID'],$this->INVOIC_ID()]);
        if (!$result){
            return 0;
        }
        $re = json_encode($result, JSON_PRETTY_PRINT);

        return $re;
    }

    public function loadEmpImg()
    {
        self::$Order->setTable("INSURANCECOMM");
        $re = self::$Order->find($_POST['id']);
        return App::$path."img/emp/".$re->AVATAR;
    }

    public function profile()
    {
        self::$Order->setTable("INSURANCECOMM");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $profile = self::$Order->profile($id);
        $this->render('emp/profile',compact('profile'));
    }

    public function printBill()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        self::$Bransh->setTable("BRANSH");
        $Bransh = self::$Bransh->find(App::$BranshID);

        $invoic = self::$Order->findInvo($id);
        $details = self::$Order->loadItem(" AND INVOIC_DETIALS.INVO_ID = {$id} ");

        $this->renderBill('print/invoic',compact('Bransh','invoic','details'));
    }

    public function delete()
    {
        self::$Order->setTable("INSURANCECOMM");
        if (isset($_POST['id'])) {
            $re = self::$Order->delete($_POST['id']);
            if($re)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }

    public function deleteItem()
    {
        if (!empty($_POST) ) {


            if (self::$Order->TestInsuranceStatus([$_POST['ITEM_ID'],$this->INVOIC_ID()])){
                $where = " WHERE ITEM_ID = {$_POST['ITEM_ID']}";
                $where .= " AND INVO_ID = {$this->INVOIC_ID()}";
                self::$Order->setTable("DELAY_COMPANY");
                self::$Order->deleteItem($where);
            }

            $where = " WHERE ITEM_ID = {$_POST['ITEM_ID']}";
            $where .= " AND INVO_ID = {$this->INVOIC_ID()}";
            self::$Order->setTable("INVOIC_DETIALS");
            $rs = self::$Order->deleteItem($where);

            if ($rs){
                return 1;
            }else{
                return 0;
            }

        }
    }

    public function printlist()
    {
        $filter = '';
        if (isset($_SESSION['filter']))
        {
            $filter = $_SESSION['filter'];
        }

        $stmt = self::$Order->load($filter);
        $this->pdf('emp/printlist',compact('emps'));
    }
}