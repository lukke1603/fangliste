<?php

namespace MVC;

use MVC\Library\View;
use MVC\Library\NotFoundException;
use MVC\Model\User;



define('PATH_ROOT', __DIR__.DIRECTORY_SEPARATOR);
require_once PATH_ROOT.'Library'.DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'init.autoloader.php';

$user = User::findFirst(array('criteria'=>1));


require_once PATH_ROOT.'Library'.DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'constants'.DIRECTORY_SEPARATOR.'constants.sys.php';
require_once PATH_ROOT.'Library'.DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'init.session.php';
require_once PATH_ROOT.'Library'.DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'constants'.DIRECTORY_SEPARATOR.'constants.path.php';
require_once PATH_ROOT.'Library'.DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'constants'.DIRECTORY_SEPARATOR.'constants.user.php';
require_once PATH_ROOT.'Library'.DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'init.user.php';






$url = (isset($_GET["_url"])) ? $_GET["_url"] : '';
$urlParts = explode('/', $url);

$controllerName = (isset($urlParts[0]) && $urlParts[0]) ? $urlParts[0] : 'index';
$controllerClassName = '\\MVC\\Controller\\' . ucfirst($controllerName) . 'Controller';

$actionName = (isset($urlParts[1]) && $urlParts[1]) ? $urlParts[1] : 'index';
$actionMethodName = $actionName . 'Action';


try{
	if( ! class_exists($controllerClassName)){
		throw new NotFoundException();
	}

	$controller = new $controllerClassName();
	if( ! $controller instanceof \MVC\Controller\Controller || ! method_exists($controller, $actionMethodName)){
		throw new NotFoundException();
	}

	$view = new View(__DIR__ . DIRECTORY_SEPARATOR . 'views', $controllerName, $actionName);
	$controller->setView($view);

	$controller->$actionMethodName();
	$view->render();
}catch(NotFoundException $ex){
	http_response_code(404);
	echo "Page not found: " . $controllerClassName . '::' . $actionMethodName;
}catch(Exception $ex){
	http_response_code(500);
	echo "Exception: " . $ex->getMessage() . ' ' . $ex->getTraceAsString();
}
	

