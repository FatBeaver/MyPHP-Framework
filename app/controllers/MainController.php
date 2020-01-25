<?php

namespace app\controllers;

use myframe\core\base\Controller;
use app\models\Main;

class MainController extends Controller
{   
    public function actionIndex()
    {    
        $model = new Main();
        $model->save();

        $this->render('index', [
        ]);
    }
    
    public function actionPosts()
    {
        echo __METHOD__;
    }
}