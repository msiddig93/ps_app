<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class  PurchaseController extends Controller
{
    private static $Order;
    private static $Stock;

    public function __construct()
    {
        parent::__construct();
        self::$Order = $this->loadModel('Purchase');
        self::$Stock = $this->loadModel('Stock');
    }

    public function index()
    {
        $form = new Form($_POST);

        self::$Order->setTable("product");
        $products = self::$Order->extract("id","product_name");

        self::$Order->setTable("vendor");
        $vendors = self::$Order->extract("id","vend_name");

        $this->render('purchase/order',compact('form','products','vendors'));
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
        $number =1;
        foreach($stmt as $result):
            $re.="<tr>
                        <td>
                           ". $number ."
                        </td>
                        
                        <td>
                           ". $result->vend_name ."
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
                               href='".App::$path."purchase/printBill/". $result->id ."'
                               target='_blank'
                               title='طباعة'><i class='fa fa-print'></i>
                            </a> 
                            <a class='btn btn-danger'
                                element_id='". $result->id ."'
                                onclick='DeleteOrder(this ,event);'
                                title='حذف'><i class='fa fa-ban'></i>
                            </a>
                        </td>
                    </tr>";
                    $number++;
        endforeach;
        return $re;
    }

    public function loadItem()
    {

        $stmt = self::$Order->loadItem(" AND purchase_order_details.purchase_order_id = ".$this->INVOIC_ID());
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
                               element_id='". $result->product_id ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $result->id ."'
                               title='حذف'
                               onclick='DeleteElement(this ,event);' >
                                <i class='fa fa-trash-o'></i></a>
                        </td>
                    </tr>";
                $number++;
        endforeach;
        return $re;
    }

    public function loadAddID()
    {
        return self::$Order->NextID();
    }

    public function INVOIC_ID()
    {
        self::$Order->setTable("purchase_order");
        return self::$Order->NextID();
    }

    public function add()
    {
        if (!empty($_POST) ) {
            $stmt = self::$Order->loadItem(" AND purchase_order_details.purchase_order_id = ".$this->INVOIC_ID());

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
                'total_price' => $_POST['total_price'],
                'vendor_id' => $_POST['vendor_id'],
                'order_date' => date('Y-m-d H:m:i'),
                'created_by' => $_SESSION['emp']->ID,
            ];

            self::$Order->setTable("purchase_order");
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
                'purchase_order_id' => $_POST['purchase_order_id'],
                'product_id' => $_POST['product_id'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
                'discount' => $_POST['discount'],
            ];

            self::$Order->setTable("purchase_order_details");
            $rs = self::$Order->create($params);

            if ($rs) {
                self::$Order->setTable("stockroom");
                $product = self::$Order->find($_POST['product_id']);
                
                if(!empty($product)){
                    $params =[
                        'qte' => $product->qte + $_POST['quantity'],
                    ];
                    self::$Order->update($product->id, $params);                    
                }else{
                    $params =[
                        'id' => null,
                        'product_id' => $_POST['product_id'],
                        'sale_price' => $_POST['price'],
                        'purchase_price' => $_POST['price'],
                        'qte' => $_POST['quantity'],
                        'created_at ' => date('Y-m-d H:m:i'),
                    ];
                    
                    self::$Order->create($params);
                }

                
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
            
            $params =[
                'purchase_order_id' => $_POST['purchase_order_id'],
                'product_id' => $_POST['product_id'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
                'discount' => $_POST['discount'],
            ];

            self::$Order->setTable("purchase_order_details");
            $rs = self::$Order->update(self::$Order->loadEditItem([$_POST['product_id'],$_POST['purchase_order_id']])->id, $params);

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
        $stmt = self::$Order->loadItem(" AND purchase_order_details.purchase_order_id = ".$this->INVOIC_ID());
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

    public function delete()
    {
        
        if (isset($_POST['id'])) {
            $stmt = self::$Order->loadItem(" AND purchase_order_details.purchase_order_id = ".$_POST['id']);
            
            if(!empty($stmt)){
                self::$Order->setTable("purchase_order_details");
                foreach($stmt as $item){
                    $re = self::$Order->delete($item->id);
                }
            }

            self::$Order->setTable("purchase_order");
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
            self::$Order->setTable("purchase_order_details");
            if (isset($_POST['ITEM_ID'])) {
                $re = self::$Order->delete($_POST['ITEM_ID']);
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

    public function printBill()
    {
        self::$Order->setTable("purchase_order ");
        $sale_order = self::$Order->find($_GET['id']);

        self::$Order->setTable("vendor");
        $customer = self::$Order->find($sale_order->vendor_id);

        self::$Order->setTable("emp");
        $emp = self::$Order->find($sale_order->created_by);

        $order_details = self::$Order->loadItem(" AND purchase_order_details.purchase_order_id = ".$sale_order->id);
        
        $sales = self::$Order->load();
        $this->renderBill('purchase/printbill',compact('sale_order','customer','emp','order_details'));
    }
}