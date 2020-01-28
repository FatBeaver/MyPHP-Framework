<?php

namespace app\controllers;

use app\models\User;
use myframe\core\base\Controller;

/**
 * class UserController
 *
 * Класс работающий с авторизацией/регистрацией;
 */
class UserController extends Controller
{
    /**
     * Действие регистрирующее пользователя;
     *
     * @throws \Exception
     */
    public function actionSignUp(): void
    {
        if (isset($_POST['submit'])) {

            $user = new User();

            if ($user->uploadData($_POST) && $user->validate($user->rulesForSignUp)) {
                $user->signUp();
                $this->redirect('/');
            }
        }

        $this->render('signup');
    }

    /**
     * Действие авторизующее пользователя
     *
     * @throws \Exception
     */
    public function actionLogin(): void
    {
        if (isset($_POST['submit'])) {
            $user = new User();

            if ($user->uploadData($_POST) && $user->validate($user->rulesForLogin)) {
                if ($user->login()) {
                    $this->redirect('/');
                }
                $this->redirect('/user/login');
            }
        }

        $this->render('login');
    }

    /**
     * Дейсвтие разлогинивающее пользователя
     */
    public function actionLogout(): void
    {
        $user = new User();
        $user->logout();
        $this->redirect('/user/login');
    }
}