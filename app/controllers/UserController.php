<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignUpForm;
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

            $signUpForm = new SignUpForm();

            if ($signUpForm->uploadData($_POST) && $signUpForm->validate($signUpForm->rules)) {
                $signUpForm->signUp();
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

            $loginForm = new LoginForm();

            if ($loginForm->uploadData($_POST) && $loginForm->validate($loginForm->rules)) {
                $loginForm->login();
                $this->redirect('/');
            }
        }
        
        $this->render('login');
    }

    /**
     * Дейсвтие разлогинивающее пользователя
     */
    public function actionLogout(): void
    {
        User::logout();
        $this->redirect('/user/login');
    }
}