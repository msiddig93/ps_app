<?php
namespace App\Controller;

use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class Controller
{
    protected static $view_path;
    protected static $template = 'defualt';

    public function __construct()
    {

        self::$view_path = ROOT.'/App/Views/';

        foreach ($_POST as $key => $value ):
            $_POST[$key] = htmlentities($value);
        endforeach;
    }

    protected function loadModel($model_name)
    {
        return \App::getInstance()->getModel($model_name);
    }

    protected function render($view , $variables = [])
    {
        ob_start();
        extract($variables);
        include(self::$view_path . $view .".php");
        $content = ob_get_clean();
        include(self::$view_path . "templates/".self::$template.".php");
    }

    protected function renderBill($view , $variables = [])
    {
        ob_start();
        extract($variables);
        include(self::$view_path . $view .".php");
        $content = ob_get_clean();
        include(self::$view_path . "templates/bill.php");
    }

    protected function pdf($view , $variables = [])
    {
        ob_start();
        extract($variables);
        include(self::$view_path . $view .".php");
        $content = ob_get_clean();
        include(self::$view_path . "templates/print.php");

    }

    protected function redirect($location)
    {
        header('location: '.$location); 
    }
}