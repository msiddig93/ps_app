<?php
define('ROOT',dirname(__DIR__));
include(ROOT."/App/App.php");
App::load();
App::$path = "http://".$_SERVER['SERVER_NAME']."/PS_App/Public/";
App::$BranshID = 1;

if (isset($_POST['ajax_action'])) {
	$request = explode('.' ,$_POST['ajax_action']);
    $controller = '\App\Controller\\'. ucfirst($request[0]).'Controller';
	$action = $request[1];
	$controller = new $controller();
	echo $articles = $controller->$action();	
}
else
{

	if(isset($_GET['p']))
	{
	    $p = $_GET['p'];
	}
	else
	{
	    $p = 'home/';
	}

	$p = explode('/' ,rtrim( $p , '/'));
	$action = 'index';

	// Add the Controller .
	if(isset($p[0]))
	{
	    $controllerName = $p[0];
	}

	if(isset($p[1]))
	{
	    $action = $p[1];
	}

	if (!isset($_SESSION['emp']) == true)
    {
        $controllerName = "emp";
        $action = "login";
    }

    App::getInstance()->setPage(strtolower($controllerName));
    $controller = '\App\Controller\\'. ucfirst($controllerName).'Controller';
	$controller = new $controller();
	$articles = $controller->$action();
}

