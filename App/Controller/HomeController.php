<?php
namespace App\Controller;
use App\Models;

use App;
use App\HTML\Form;
use App\Upload;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class HomeController extends Controller
{
    private static $Bransh;

    public function __construct()
    {
        parent::__construct();
//        self::$Bransh = $this->loadModel('Bransh');
    }

    public function index(){

        $this->render('home');
    }
}