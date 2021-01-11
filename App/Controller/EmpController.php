<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class EmpController extends Controller
{
    private static $Emp;

    public function __construct()
    {
        parent::__construct();
        self::$Emp = $this->loadModel('Emp');
    }

    public function index()
    {
        $form = new Form($_POST);
        $this->render('emp/index',compact('form'));
    }

    public function load()
    {
        self::$Emp->setTable("emp");
        $emps = self::$Emp->load();
        $re = "";
        foreach($emps as $emp):
            if ( $emp->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/emp/". $emp->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $emp->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $emp->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $emp->ADDRSS ."</p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $emp->PHONE ."</p>
                            <p>". $emp->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $emp->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $emp->ID ."'
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
        self::$Emp->setTable("emp");
        return self::$Emp->NextID();
    }

    public function logout()
    {
        if (isset($_SESSION['emp'])){
            $_SESSION = array();
            session_unset();
            session_destroy();
            unset($_COOKIE['cm_app_emp_id']);
            setcookie("cm_app_emp_id",null, -1,"/");
            $this->redirect(App::$path ."emp/login");
        }
    }

    public function login()
    {
        if (isset($_SESSION['emp'])){
            $this->redirect(App::$path ."/home");
        }
        
        $form = new Form($_POST);
        $error = false;
        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $rs = self::$Emp->login($login , $pass);

            if ( $rs )
            {
                $this->redirect(App::$path ."home");
            }
            else
            {
                $error = true;
            }
        }

        $this->render('emp/login',compact('form','error'));
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

        $_SESSION['search-emp'] = $filter;

        self::$Emp->setTable("emp");
        $emps = self::$Emp->load($filter);
        $re = "";
        foreach($emps as $emp):
            if ( $emp->ID > 0    ) {
                $re.="<tr>
                        <td>
                            <a href='#'>
                                <img class='media-object avatar' src='". App::$path ."img/emp/". $emp->AVATAR ."'>
                            </a>
                        </td>
                        <td>
                            <h4>
                                <a href='#'>
                                    ". $emp->FULLNAME ."
                                </a>
                            </h4>
                            <p>إسم المستخدم : ". $emp->LOGIN ."@</p>
                        </td>
                        <td>
                            <p>العنوان : ". $emp->ADDRSS ."</p>
                        </td>
                        <td>
                            <p style='direction: ltr'> الهاتف : ". $emp->PHONE ."</p>
                            <p>". $emp->TYPE ."</p>
                        </td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $emp->ID ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $emp->ID ."'
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
        self::$Emp->setTable("emp");
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
                    'ID' => $this->loadAddID(),
                    'FULLNAME' => $_POST['FULLNAME'],
                    'PHONE' => $_POST['PHONE'],
                    'ADDRSS' => $_POST['ADDRSS'],
                    'AVATAR' => $avatar,
                    'TYPE' => $_POST['TYPE'],
                    'LOGIN' => $_POST['LOGIN'],
                    'PASS' => sha1($_POST['PASS'])
                ];


            $rs = self::$Emp->create($params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                            $_FILES['avatar'],
                            $avatar,
                            ROOT.'/public/img/emp/'
                        );

                }
                if ($rs){
                    return 1;
                }else{
                    return 0;
                }
            endif;
        }


        $this->render('emp/add',compact('form'));
    }

    public function edit()
    {
        $id = $_POST['ID'] ;
        $emp = self::$Emp->find($id);

        if (!empty($_POST) ) {
            self::$Emp->setTable("emp");
            if( $_FILES['avatar']['name'][0] != "" ){
                $avatar = $id .".". @strtolower(end(explode('.',$_FILES['avatar']['name'][0] )));
            }
            else
            {
                $avatar = $emp->AVATAR;
            }

            $params =[
                'FULLNAME' => $_POST['FULLNAME'],
                'PHONE' => $_POST['PHONE'],
                'ADDRSS' => $_POST['ADDRSS'],
                'AVATAR' => $avatar,
                'TYPE' => $_POST['TYPE'],
                'BRANSH_ID' => $_POST['BRANSH_ID'],
                'LOGIN' => $_POST['LOGIN'],
            ];

            if ( !empty($_POST['PASS']) && $_POST['PASS'] != $emp->PASS ){
                $params['PASS'] = sha1($_POST['PASS']);
            }

            $rs =  self::$Emp->update( $id ,$params);

            if ($rs):
                if ( $_FILES['avatar']['name'][0] != "" ) {
                    Upload::one(
                        $_FILES['avatar'],
                        $avatar,
                        ROOT.'/public/img/emp/'
                    );

                    if ($_SESSION['emp']->ID == $id ){
                        $_SESSION['emp'] = self::$Emp->find($id);
                    }

                }
                if ($rs){
                    return 1;
                }else{
                    return 0;
                }
            endif;
        }

        $this->render('emp/add',compact('form','emps'));
    }

    public function LoadElementEdit()
    {
        self::$Emp->setTable("emp");
        $emp = self::$Emp->find($_POST['id']);
        $re = json_encode($emp, JSON_PRETTY_PRINT);

        return $re;
    }

    public function loadEmpImg()
    {
        self::$Emp->setTable("emp");
        $re = self::$Emp->find($_POST['id']);

        if ($re) {
            return App::$path . "img/emp/" . $re->AVATAR;
        }else{
            return App::$path . "img/emp/0.png";
        }
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
        self::$Emp->setTable("emp");
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
        self::$Emp->setTable("emp");
        $emps = self::$Emp->load();
        
        $this->pdf('emp/printlist',compact('emps'));
    }
}