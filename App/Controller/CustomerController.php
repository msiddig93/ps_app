<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class CustomerController extends Controller
{
    private static $Emp;

    public function __construct()
    {
        parent::__construct();
        self::$Emp = $this->loadModel('Customer');
    }

    public function index()
    {
        $form = new Form($_POST);
        $this->render('customer/index',compact('form'));
    }

    public function load()
    {
        self::$Emp->setTable("customer");
        $customers = self::$Emp->load();
        $re = "";
        $number = 1;
        foreach($customers as $customer):
            if ( $customer->id > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/customer/". $customer->AVATAR ."'>
                            </a>
                        </td>
                        <td>".$number."</td>
                        <td>".$customer->cust_name."</td>
                        <td>".$customer->address."</td>
                        <td>".$customer->phone."</td>
                        <td>".$customer->email."</td>
                        
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $customer->id ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $customer->id ."'
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
        self::$Emp->setTable("customer");
        return self::$Emp->NextID();
    }

    public function search()
    {
        $filter = '';
        
        if (isset($_POST['FULLNAME']) && !customerty($_POST['FULLNAME'])) {
            $filter .= " AND FULLNAME LIKE '%{$_POST['FULLNAME']}%' ";
        }

        if (isset($_POST['TYPE']) && !customerty($_POST['TYPE'])) {
            $filter .= "AND TYPE LIKE '%{$_POST['TYPE']}%' ";
        }

        $_SESSION['search-customer'] = $filter;

        self::$Emp->setTable("customer");
        $customers = self::$Emp->load($filter);
        $re = "";
        foreach($customers as $customer):
            if ( $customer->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/customer/". $customer->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $customer->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $customer->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $customer->ADDRSS ."</p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $customer->PHONE ."</p>
                            <p>". $customer->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $customer->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $customer->ID ."'
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
        self::$Emp->setTable("customer");
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

            $pass = explode('@',$_POST['email'])[0];

            $params =[
                    'id' => null,
                    'cust_name' => $_POST['cust_name'],
                    'address' => $_POST['address'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'AVATAR' => $avatar,
                    'password' => sha1($pass),
                ];

            $rs = self::$Emp->create($params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                            $_FILES['avatar'],
                            $avatar,
                            ROOT.'/public/img/customer/'
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
        $customer = self::$Emp->find($id);

        if (!empty($_POST) ) {
            self::$Emp->setTable("customer");
            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $id .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = $customer->AVATAR;
            }

            $params =[
                'cust_name' => $_POST['cust_name'],
                'address' => $_POST['address'],
                'email' => $_POST['email'],
                'AVATAR' => $avatar,
                'phone' => $_POST['phone'],
            ];

            $rs =  self::$Emp->update( $id ,$params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                        $_FILES['avatar'],
                        $avatar,
                        ROOT.'/public/img/customer/'
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
        self::$Emp->setTable("customer");
        $customer = self::$Emp->find($_POST['id']);
        $re = json_encode($customer, JSON_PRETTY_PRINT);

        return $re;
    }

    public function loadEmpImg()
    {
        self::$Emp->setTable("customer");
        $re = self::$Emp->find($_POST['id']);

        if ($re) {
            return App::$path . "img/customer/" . $re->AVATAR;
        }else{
            return App::$path . "img/customer/0.png";
        }
    }

    public function profile()
    {
        self::$Emp->setTable("customer");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $profile = self::$Emp->profile($id);
        $this->render('customer/profile',compact('profile'));
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
        self::$Emp->setTable("customer");
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
        $filter = '';
        if (isset($_SESSION['filter']))
        {
            $filter = $_SESSION['filter'];
        }

        $customers = self::$Emp->load($filter);
        $this->pdf('customer/printlist',compact('customers'));
    }
}