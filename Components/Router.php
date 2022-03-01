<?php

declare(strict_types=1);

namespace components;

use Controllers\MainController;
use Controllers\RegistrationController;

class Router
{
    private $routes;
    private $controllers = [
        'MainController' => MainController::class,
        'RegistrationController' => RegistrationController::class];

    public function __construct()
    {
        $this -> routes = include('../config/routes.php');
    }

    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path){

            if (preg_match("~$uriPattern~", $uri)){

                $segments = explode('/', $path);
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));

                $controller = $this->controllers[$controllerName];

                $result = (new $controller)->$actionName();
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