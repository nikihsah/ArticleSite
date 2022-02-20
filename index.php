<?php



//composer ^_^

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once ROOT . '/vendor/autoload.php';

use components\Router;

//4 Вызов Route
$route = new Router();
$route->run();