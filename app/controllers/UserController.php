<?php

namespace app\controllers;

use app\models\User;
use myframe\core\Db;
use myframe\core\base\Controller;
use myframe\libs\Debug;


/**
 * Класс работающий с авторизацией/регистрацией;
 */
class UserController extends Controller
{
    public function actionSignUp()
    {
        if (isset($_POST['submit'])) {
            Db::connect();

            $user = new User();
            $user->uploadData($_POST);

            Debug::print($user);
        }

        $this->render('signup');
    }


    public function actionLogin()
    {
        if (isset($_POST['submit'])) {

        }

        $this->render('login');
    }


    public function actionLogout()
    {
        echo __CLASS__;
    }
}