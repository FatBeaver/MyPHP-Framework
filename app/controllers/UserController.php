<?php

namespace app\controllers;

use app\models\User;
use myframe\core\Db;
use myframe\core\base\Controller;

/**
 * class UserController
 *
 * Класс работающий с авторизацией/регистрацией;
 */
class UserController extends Controller
{
    public function actionSignUp(): void
    {
        if (isset($_POST['submit'])) {
            $user = new User();
            if ($user->uploadData($_POST) && $user->validate()) {
                $user->signUp();
                $this->redirect('/');
            }
        }
        $this->render('signup');
    }


    public function actionLogin():void
    {
        if (isset($_POST['submit'])) {

            $userRules = [
                'required' => [
                    ['password'], ['email'],
                ],
                'lengthMin' => [
                    ['password', 6],
                ],
                'email' => [
                    ['email'],
                ],
            ];

            $user = new User();
            if ($user->uploadData($_POST) && $user->validate($userRules)) {
                if ($user->login()) {
                    $this->redirect('/');
                }
                $this->redirect('/user/login');
            }
        }
        $this->render('login');
    }


    public function actionLogout(): void
    {
        $user = new User();
        $user->logout();
        $this->redirect('/user/login');
    }
}