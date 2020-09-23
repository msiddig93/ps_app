<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class StockController extends Controller
{
    private static $Emp;

    public function __construct()
    {
        parent::__construct();
        self::$Emp = $this->loadModel('Stock');
    }

    public function index()
    {
        $form = new Form($_POST);
        $this->render('stock/index',compact('form'));
    }

    public function load()
    {
        self::$Emp->setTable("stockroom");
        $stockrooms = self::$Emp->load();
        $re = "";
        $number = 1;
        foreach($stockrooms as $stockroom):
            if ( $stockroom->id > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/stockroom/". $stockroom->AVATAR ."'>
                            </a>
                        </td>
                        <td>".$number."</td>
                        <td>".$stockroom->vend_name."</td>
                        <td>".$stockroom->address."</td>
                        <td>".$stockroom->phone."</td>
                        <td>".$stockroom->email."</td>
                        
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $stockroom->id ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $stockroom->id ."'
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
        self::$Emp->setTable("stockroom");
        return self::$Emp->NextID();
    }

    public function search()
    {
        $filter = '';
        
        if (isset($_POST['FULLNAME']) && !stockroomty($_POST['FULLNAME'])) {
            $filter .= " AND FULLNAME LIKE '%{$_POST['FULLNAME']}%' ";
        }

        if (isset($_POST['TYPE']) && !stockroomty($_POST['TYPE'])) {
            $filter .= "AND TYPE LIKE '%{$_POST['TYPE']}%' ";
        }

        $_SESSION['search-stockroom'] = $filter;

        self::$Emp->setTable("stockroom");
        $stockrooms = self::$Emp->load($filter);
        $re = "";
        foreach($stockrooms as $stockroom):
            if ( $stockroom->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/stockroom/". $stockroom->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $stockroom->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $stockroom->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $stockroom->ADDRSS ."</p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $stockroom->PHONE ."</p>
                            <p>". $stockroom->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $stockroom->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $stockroom->ID ."'
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
        self::$Emp->setTable("stockroom");
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
                            ROOT.'/public/img/stockroom/'
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
        $stockroom = self::$Emp->find($id);

        if (!empty($_POST) ) {
            self::$Emp->setTable("stockroom");
            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $id .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = $stockroom->AVATAR;
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
                        ROOT.'/public/img/stockroom/'
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
        self::$Emp->setTable("stockroom");
        $stockroom = self::$Emp->find($_POST['id']);
        $re = json_encode($stockroom, JSON_PRETTY_PRINT);

        return $re;
    }

    public function loadEmpImg()
    {
        self::$Emp->setTable("stockroom");
        $re = self::$Emp->find($_POST['id']);

        if ($re) {
            return App::$path . "img/stockroom/" . $re->AVATAR;
        }else{
            return App::$path . "img/stockroom/0.png";
        }
    }

    public function profile()
    {
        self::$Emp->setTable("stockroom");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $profile = self::$Emp->profile($id);
        $this->render('stockroom/profile',compact('profile'));
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
        self::$Emp->setTable("stockroom");
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

        $stockrooms = self::$Emp->load($filter);
        $this->pdf('stockroom/printlist',compact('stockrooms'));
    }
}