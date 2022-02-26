<?php

namespace Controllers;

use components\BD;

class MainController
{
    public function __construct(){

    }

    public function actionIndex(){
        echo "<h1>main</h1>";

        return true;
    }
}