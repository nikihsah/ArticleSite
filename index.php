<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/Components/Router.php');

include_once(ROOT . '/Components/Server.php');
$server = new Server();
$server->connect();

//4 Вызов Route
$route = new Router();
$route->run();