<?php

//composer ^_^

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/Components/Router.php');
require __DIR__ . '/vendor/autoload.php';

//4 Вызов Route
$route = new Router();
dd('asdad');
$route->run();