<?php

namespace app\controllers;

use myframe\core\App;
use myframe\core\base\Controller;
use myframe\libs\debug\Debug;

class MainController extends Controller
{   
    public function actionIndex()
    {   
        $this->render('index', []);
    }
    
    public function actionPosts()
    {
        $posts = [
            ['id' => 1, 'name' => 'Post_1', 'content' => 'jajajajajaja'],
            ['id' => 2, 'name' => 'Post_2', 'content' => 'ohohohohohohoh'],
            ['id' => 3, 'name' => 'Post_3', 'content' => 'ihihihihihihhh'],
            ['id' => 4, 'name' => 'Post_4', 'content' => 'eheheheheheeheh'],
            ['id' => 5, 'name' => 'Post_5', 'content' => 'azazazazaazazaza'],
            ['id' => 6, 'name' => 'Post_6', 'content' => 'lolololololoololo'],
            ['id' => 7, 'name' => 'Post_7', 'content' => 'lalalalalallalala'],
            ['id' => 8, 'name' => 'Post_8', 'content' => 'yoyoyoyoyoyoyoyoyo'],
        ];

        $page = App::$components->request->get('page');

    }
}