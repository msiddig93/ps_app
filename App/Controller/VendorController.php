<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class VendorController extends Controller
{
    private static $Emp;

    public function __construct()
    {
        parent::__construct();
        self::$Emp = $this->loadModel('Vendor');
    }

    public function index()
    {
        $form = new Form($_POST);
        $this->render('vendor/index',compact('form'));
    }

    public function load()
    {
        self::$Emp->setTable("vendor");
        $vendors = self::$Emp->load();
        $re = "";
        $number = 1;
        foreach($vendors as $vendor):
            if ( $vendor->id > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/vendor/". $vendor->AVATAR ."'>
                            </a>
                        </td>
                        <td>".$number."</td>
                        <td>".$vendor->vend_name."</td>
                        <td>".$vendor->address."</td>
                        <td>".$vendor->phone."</td>
                        <td>".$vendor->email."</td>
                        
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $vendor->id ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $vendor->id ."'
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
        self::$Emp->setTable("vendor");
        return self::$Emp->NextID();
    }

    public function search()
    {
        $filter = '';
        
        if (isset($_POST['FULLNAME']) && !vendorty($_POST['FULLNAME'])) {
            $filter .= " AND FULLNAME LIKE '%{$_POST['FULLNAME']}%' ";
        }

        if (isset($_POST['TYPE']) && !vendorty($_POST['TYPE'])) {
            $filter .= "AND TYPE LIKE '%{$_POST['TYPE']}%' ";
        }

        $_SESSION['search-vendor'] = $filter;

        self::$Emp->setTable("vendor");
        $vendors = self::$Emp->load($filter);
        $re = "";
        foreach($vendors as $vendor):
            if ( $vendor->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/vendor/". $vendor->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $vendor->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $vendor->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $vendor->ADDRSS ."</p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $vendor->PHONE ."</p>
                            <p>". $vendor->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $vendor->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $vendor->ID ."'
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
        self::$Emp->setTable("vendor");
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
                    'vend_name' => $_POST['vend_name'],
                    'address' => $_POST['address'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'AVATAR' => $avatar,
                ];

            $rs = self::$Emp->create($params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                            $_FILES['avatar'],
                            $avatar,
                            ROOT.'/public/img/vendor/'
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
        $vendor = self::$Emp->find($id);

        if (!empty($_POST) ) {
            self::$Emp->setTable("vendor");
            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $id .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = $vendor->AVATAR;
            }

            $params =[
                'vend_name' => $_POST['vend_name'],
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
                        ROOT.'/public/img/vendor/'
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
        self::$Emp->setTable("vendor");
        $vendor = self::$Emp->find($_POST['id']);
        $re = json_encode($vendor, JSON_PRETTY_PRINT);

        return $re;
    }

    public function loadEmpImg()
    {
        self::$Emp->setTable("vendor");
        $re = self::$Emp->find($_POST['id']);

        if ($re) {
            return App::$path . "img/vendor/" . $re->AVATAR;
        }else{
            return App::$path . "img/vendor/0.png";
        }
    }

    public function profile()
    {
        self::$Emp->setTable("vendor");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $profile = self::$Emp->profile($id);
        $this->render('vendor/profile',compact('profile'));
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
        self::$Emp->setTable("vendor");
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

        $vendors = self::$Emp->load($filter);
        $this->pdf('vendor/printlist',compact('vendors'));
    }
}