<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class StockController extends Controller
{
    private static $Stock;

    public function __construct()
    {
        parent::__construct();
        self::$Stock = $this->loadModel('stock');
    }

    public function index()
    {
        $form = new Form($_POST);
        $this->render('stock/index',compact('form'));
    }

    public function load()
    {
        $items = self::$Stock->load();
        $re = "";
        $number = 1;
        foreach($items as $item):
            $re.="<tr>
                    <td>".$number."</td>
                    <td>".$item->product_name."</td>
                    <td>".$item->cat_name."</td>
                    <td>".$item->purchase_price."</td>
                    <td>".$item->sale_price."</td>
                    <td><strong>".$item->qte."</strong></td>
                </tr>";
            $number++;
        endforeach;
        return $re;
    }

    public function loadAddID()
    {
        self::$Stock->setTable("item");
        return self::$Stock->NextID();
    }

    public function search()
    {
        $filter = '';
        
        if (isset($_POST['FULLNAME']) && !itemty($_POST['FULLNAME'])) {
            $filter .= " AND FULLNAME LIKE '%{$_POST['FULLNAME']}%' ";
        }

        if (isset($_POST['TYPE']) && !itemty($_POST['TYPE'])) {
            $filter .= "AND TYPE LIKE '%{$_POST['TYPE']}%' ";
        }

        $_SESSION['search-item'] = $filter;

        self::$Stock->setTable("item");
        $items = self::$Stock->load($filter);
        $re = "";
        foreach($items as $item):
            if ( $item->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/item/". $item->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $item->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $item->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $item->ADDRSS ."</p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $item->PHONE ."</p>
                            <p>". $item->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $item->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $item->ID ."'
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
        self::$Stock->setTable("item");
        $avatar = $this->loadAddID();
        $form = new Form($_POST);
        if (!Stockty($_POST) ) {

            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $avatar .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = "0.png";
            }

            $params =[
                    'id' => null,
                    'vend_name' => $_POST['vend_name'],
                    'address' => $_POST['address'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'AVATAR' => $avatar,
                ];

            $rs = self::$Stock->create($params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                            $_FILES['avatar'],
                            $avatar,
                            ROOT.'/public/img/item/'
                        );

                }
                if ($rs){
                    return 1;
                }else{
                    return 0;
                }
            endif;
        }

    }

    public function edit()
    {
        $id = $_POST['ID'] ;
        $item = self::$Stock->find($id);

        if (!Stockty($_POST) ) {
            self::$Stock->setTable("item");
            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $id .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = $item->AVATAR;
            }

            $params =[
                'vend_name' => $_POST['vend_name'],
                'address' => $_POST['address'],
                'email' => $_POST['email'],
                'AVATAR' => $avatar,
                'phone' => $_POST['phone'],
            ];

            $rs =  self::$Stock->update( $id ,$params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                        $_FILES['avatar'],
                        $avatar,
                        ROOT.'/public/img/item/'
                    );

                }
                if ($rs){
                    return 1;
                }else{
                    return 0;
                }
            endif;
        }

    }

    public function LoadElementEdit()
    {
        self::$Stock->setTable("item");
        $item = self::$Stock->find($_POST['id']);
        $re = json_encode($item, JSON_PRETTY_PRINT);

        return $re;
    }

    public function loadStockImg()
    {
        self::$Stock->setTable("item");
        $re = self::$Stock->find($_POST['id']);

        if ($re) {
            return App::$path . "img/item/" . $re->AVATAR;
        }else{
            return App::$path . "img/item/0.png";
        }
    }

    public function profile()
    {
        self::$Stock->setTable("item");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $profile = self::$Stock->profile($id);
        $this->render('item/profile',compact('profile'));
    }


    public function printinfos()
    {
        self::$Stock->setTable("Articles");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $article = self::$Stock->findArticle($id);
        $this->pdf('articles/printinfos',compact('article'));
    }

    public function delete()
    {
        self::$Stock->setTable("item");
        if (isset($_POST['id'])) {
            $re = self::$Stock->delete($_POST['id']);
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

    public function printlist()
    {
        $items = self::$Stock->load();
        $this->pdf('stock/printlist',compact('items'));
    }
}