<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;

class CategoryController extends Controller
{
    private static $Emp;

    public function __construct()
    {
        parent::__construct();
        self::$Emp = $this->loadModel('Category');
    }

    public function index()
    {
        $form = new Form($_POST);
        $this->render('stock/category',compact('form'));
    }

    public function load()
    {
        self::$Emp->setTable("category");
        $categorys = self::$Emp->load();
        $re = "";
        $number = 1;
        foreach($categorys as $category):
            if ( $category->id > 0    ) {
                $re.="<tr>
                        <td>".$number."</td>
                        <td>".$category->cat_name."</td>
                        <td>".$category->cat_desc."</td>
                        <td class='table-actions'>
                            <a class='btn btn-success btn-xs'
                               element_id='". $category->id ."'
                               onclick='EditElement(this,event)'
                               title='تعديل'><i class='fa fa-pencil-square'></i></a>
                            <a class='btn btn-danger btn-xs'
                               element_id='". $category->id ."'
                               title='حذف'
                               onclick='DeleteElement(this ,event);' >
                                <i class='fa fa-trash-o'></i></a>
                        </td>
                    </tr>";
            }
            $number ++;
        endforeach;
        return $re;
    }

    public function loadAddID()
    {
        self::$Emp->setTable("category");
        return self::$Emp->NextID();
    }

    public function add()
    {
        self::$Emp->setTable("category");
        $avatar = $this->loadAddID();
        $form = new Form($_POST);
        if (!empty($_POST) ) {

            $params =[
                    'id' => null,
                    'cat_name' => $_POST['cat_name'],
                    'cat_desc' => $_POST['cat_desc'],
                ];

            $rs = self::$Emp->create($params);

            if ($rs):
                return 1;
            endif;

            return 0;
        }

    }

    public function edit()
    {
        $id = $_POST['ID'] ;
        $category = self::$Emp->find($id);

        if (!empty($_POST) ) {

            $params =[
                'cat_name' => $_POST['cat_name'],
                'cat_desc' => $_POST['cat_desc'],
            ];

            $rs = self::$Emp->update( $id ,$params);

            if ($rs):
                return 1;
            endif;

            return 0;
        }

    }

    public function LoadElementEdit()
    {
        self::$Emp->setTable("category");
        $category = self::$Emp->find($_POST['id']);
        $re = json_encode($category, JSON_PRETTY_PRINT);

        return $re;
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
        self::$Emp->setTable("category");
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

        $categorys = self::$Emp->load($filter);
        $this->pdf('category/printlist',compact('categorys'));
    }
}