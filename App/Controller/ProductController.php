<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class ProductController extends Controller
{
    private static $Emp;

    public function __construct()
    {
        parent::__construct();
        self::$Emp = $this->loadModel('Product');
    }

    public function index()
    {
        $form = new Form($_POST);

        self::$Emp->setTable("category");
        $category = self::$Emp->extract("id","cat_name");
        $this->render('stock/product',compact('form','category'));
    }

    public function load()
    {
        self::$Emp->setTable("product");
        $products = self::$Emp->load();
        $re = "";
        $number = 1;
        foreach($products as $product):
            if ( $product->id > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/product/". $product->product_img ."'>
                            </a>
                        </td>
                        <td>".$number."</td>
                        <td>".$product->product_name."</td>
                        <td>".$product->cat_name."</td>
                        <td>".$product->product_dec."</td>
                        <td>".$product->purchase_price."</td>
                        <td>".$product->sale_price."</td>
                        <td>".$product->mini_stock."</td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $product->id ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $product->id ."'
                               title='حذف'
                               onclick='DeleteElement(this ,event);' >
                                <i class='fa fa-trash-o'></i></a>
                        </td>
                    </tr>";
            }

        endforeach;
        return $re;
    }

    public function loadAddID()
    {
        self::$Emp->setTable("product");
        return self::$Emp->NextID();
    }

    public function search()
    {
        $filter = '';
        
        if (isset($_POST['FULLNAME']) && !productty($_POST['FULLNAME'])) {
            $filter .= " AND FULLNAME LIKE '%{$_POST['FULLNAME']}%' ";
        }

        if (isset($_POST['TYPE']) && !productty($_POST['TYPE'])) {
            $filter .= "AND TYPE LIKE '%{$_POST['TYPE']}%' ";
        }

        $_SESSION['search-product'] = $filter;

        self::$Emp->setTable("product");
        $products = self::$Emp->load($filter);
        $re = "";
        foreach($products as $product):
            if ( $product->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/product/". $product->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $product->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $product->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $product->ADDRSS ."</p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $product->PHONE ."</p>
                            <p>". $product->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $product->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $product->ID ."'
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
        self::$Emp->setTable("product");
        $avatar = $this->loadAddID();
        $form = new Form($_POST);
        if (!empty($_POST) ) {

            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $avatar .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = "0.png";
            }

            $params =[
                    'id' => null,
                    'product_name' => $_POST['product_name'],
                    'product_dec' => $_POST['product_dec'],
                    'mini_stock' => $_POST['mini_stock'],
                    'product_img' => $avatar,
                    'category_id' => $_POST['category_id'],
                    'purchase_price' => $_POST['purchase_price'],
                    'sale_price' => $_POST['sale_price'],
                ];

            $rs = self::$Emp->create($params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                            $_FILES['avatar'],
                            $avatar,
                            ROOT.'/public/img/product/'
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
        $product = self::$Emp->find($id);

        if (!empty($_POST) ) {
            self::$Emp->setTable("product");
            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $id .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = $product->product_img;
            }

            $params =[
                'product_name' => $_POST['product_name'],
                'product_dec' => $_POST['product_dec'],
                'mini_stock' => $_POST['mini_stock'],
                'product_img' => $avatar,
                'category_id' => $_POST['category_id'],
                'purchase_price' => $_POST['purchase_price'],
                'sale_price' => $_POST['sale_price'],
            ];

            $rs =  self::$Emp->update( $id ,$params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                        $_FILES['avatar'],
                        $avatar,
                        ROOT.'/public/img/product/'
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
        self::$Emp->setTable("product");
        $product = self::$Emp->find($_POST['id']);
        $re = json_encode($product, JSON_PRETTY_PRINT);

        return $re;
    }

    public function loadEmpImg()
    {
        self::$Emp->setTable("product");
        $re = self::$Emp->find($_POST['id']);

        if ($re) {
            return App::$path . "img/product/" . $re->product_img;
        }else{
            return App::$path . "img/product/0.png";
        }
    }

    public function profile()
    {
        self::$Emp->setTable("product");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $profile = self::$Emp->profile($id);
        $this->render('product/profile',compact('profile'));
    }


    public function printinfos()
    {
        self::$Emp->setTable("Articles");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $article = self::$Emp->findArticle($id);
        $this->pdf('articles/printinfos',compact('article'));
    }

    public function delete()
    {
        self::$Emp->setTable("product");
        if (isset($_POST['id'])) {
            $re = self::$Emp->delete($_POST['id']);
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
        $products = self::$Emp->load();
        $this->pdf('stock/printProductList',compact('products'));
    }
}