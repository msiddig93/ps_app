<?php
namespace App\Controller;
//use App\Models\ArticlesModel;
use App;
use App\HTML\Form;
use App\Upload;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class PrintController extends Controller
{
    private static $Bransh;
    private static $Item;

    public function __construct()
    {
        parent::__construct();
        self::$Bransh = $this->loadModel('Bransh');
        self::$Item = $this->loadModel('Items');
    }

    public function index()
    {
        $form = new Form($_POST);
        $this->render('Bransh/index',compact('form'));
    }

    public function NewCompany()
    {
        self::$Bransh->setTable("BRANSH");
        $details = self::$Item->load();
        $this->pdf('print/newCompany',compact('details'));
    }
}