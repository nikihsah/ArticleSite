<?php

declare(strict_types=1);

namespace components;

class Router
{
    private $routes;

    public function __construct()
    {
        $this -> routes = include(ROOT . '/config/routes.php');
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path){

            if (preg_match("~$uriPattern~", $uri)){

                $segments = explode('/', $path);
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));
                $controlFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controlFile)){
                    include_once($controlFile);
                }

                $fl = fopen("file.txt", "w+");
                fwrite($fl, $controlFile . " " . $actionName);
                fclose($fl);

                $controller = new $controllerName;
                $result = $controller->$actionName();
                if($result){
                    break;
                }
            }
        }
    }

    /**
     * @return string|null
     */
    public function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        return '';
    }
}