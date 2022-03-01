<?php



//composer ^_^

use components\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';


$config = include("../config/serverData.php");

$connect = mysqli_connect(
    $config['servername'],
    $config['username'],
    $config['password'],
    $config['dbname']);

//4 Вызов Route
$route = new Router();
$route->run();