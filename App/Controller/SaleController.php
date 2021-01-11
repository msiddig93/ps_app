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
        // $products = self::$Order->extract("id","product_name");
        $products = self::$Order->extractStock("id","product_name");

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
        $number = 1;
        foreach($stmt as $result):

            $re.="<tr>
                        <td>
                           ". $number ."
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
                               href='".App::$path."sale/printBill/". $result->id ."'
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

        $stmt = self::$Order->loadItem(" AND sale_order_details.sale_order_id = ".$this->INVOIC_ID());
        
        if(!$stmt){
            return "<div class='alert alert-danger alert-block' >لم يتم إضافة أي منتجات لهذا الامر بعد</div>";
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

    public function add()
    {
        if (!empty($_POST) ) {
            $stmt = self::$Order->loadItem(" AND sale_order_details.sale_order_id = ".$this->INVOIC_ID());
        
            $params = [
                'id' => null,
                'total_price' => $_POST['total_price'],
                'customer_id' => $_POST['customer_id'],
                'order_date' => $_POST['order_date'],
                'created_by' => $_SESSION['emp']->ID,
            ];

            self::$Order->setTable("sale_order");
            $rs = self::$Order->create($params);

            if ($rs) {
                
                $current_sale_id = self::$Order->LastItem()->sale_order_id;
                $sale_order_details = self::$Order->loadItem("AND sale_order_id = {$current_sale_id}");
                foreach($sale_order_details as $order){
                    $params =[
                        'sale_order_id' => self::$Order->load()[0]->id,
                    ];
        
                    self::$Order->setTable("sale_order_details");
                    $rs = self::$Order->update($order->id, $params);
                }
                
        // 
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

            $product = self::$Order->findStock($_POST['product_id']);
           
            if( $_POST['quantity'] > $product->qte){
                return 3;
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
            
            self::$Order->setTable("sale_order_details");
            $product = self::$Order->findStock($_POST['product_id']);
            $current_oder_diatils = self::$Order->find($_POST['id']);
            $sum = $product->qte + $current_oder_diatils->quantity;
            if( $_POST['quantity'] > $sum){
                return 3;
            }

            self::$Order->setTable("stock");
            $product = self::$Order->findStock($_POST['product_id']);
            $params =[
                'qte' => $sum,
            ];
            self::$Order->update($product->id, $params);

            $params =[
                'product_id' => $_POST['product_id'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
                'discount' => $_POST['discount'],
            ];

            self::$Order->setTable("sale_order_details");
            $rs = self::$Order->update($_POST['id'], $params);

            if ($rs) {
            self::$Order->setTable("stock");
            $product = self::$Order->findStock($_POST['product_id']);
            $params =[
                'qte' => $product->qte - $_POST['quantity'],
            ];
            self::$Order->update($product->id, $params);
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
        self::$Order->setTable("sale_order_details");
        $result = self::$Order->find($_POST['ITEM_ID']);
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

    public function delete()
    {
        
        if (isset($_POST['id'])) {
            $order_details = self::$Order->loadItem("AND sale_order_id = {$_POST['id']}");
            foreach($order_details as $order){
                // update the stock qte .
                self::$Order->setTable("stock");
                $product = self::$Order->findStock($order->product_id);
                $params =[
                    'qte' => $product->qte + $order->quantity,
                ];
                self::$Order->update($product->id, $params);

                // then delete the sale order detils (^_^)
                self::$Order->setTable("sale_order_details");
                $re = self::$Order->delete($order->id);
            }
            // at last delete the sale order data .
            self::$Order->setTable("sale_order");
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

            // delete trik (-_-) <div class=""></div>
            self::$Order->setTable("sale_order_details");
            $result = self::$Order->find($_POST['ITEM_ID']);

            self::$Order->setTable("stock");
            $product = self::$Order->findStock($result->product_id);
            $params =[
                'qte' => $product->qte + $result->quantity,
            ];
            self::$Order->update($product->id, $params);

            self::$Order->setTable("sale_order_details");
            $rs = self::$Order->delete($_POST['ITEM_ID']);

            if ($rs){
                return 1;
            }else{
                return 0;
            }

        }
    }

    public function printlist()
    {
        $sales = self::$Order->load();
        $this->pdf('sale/printlist',compact('sales'));
    }

    public function printBill()
    {
        self::$Order->setTable("sale_order");
        $sale_order = self::$Order->find($_GET['id']);

        self::$Order->setTable("customer");
        $customer = self::$Order->find($sale_order->customer_id);

        self::$Order->setTable("emp");
        $emp = self::$Order->find($sale_order->created_by);

        $order_details = self::$Order->loadItem(" AND sale_order_details.sale_order_id = ".$sale_order->id);
        
        $sales = self::$Order->load();
        $this->renderBill('sale/printbill',compact('sale_order','customer','emp','order_details'));
    }
}