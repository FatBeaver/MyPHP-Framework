<?php

namespace app\controllers;

use myframe\core\App;
use myframe\core\base\Controller;
use app\models\Main;
use myframe\core\Db;
use myframe\libs\Debug;

class MainController extends Controller
{   
    public function actionIndex()
    {

        $this->render('index', [
        ]);
    }
    
    public function actionPosts()
    {
        echo __METHOD__;
    }
}