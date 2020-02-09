<?php

namespace app\models;

use myframe\core\base\Model;
use myframe\libs\debug\Debug;

class LoginForm extends Model 
{   
    /**
     * Флаг для создания auth_key
     *
     * @var bool
     */
    public bool $rememberMe = false;

    /**
     * Пароль пользователя.
     * 
     * @var string
     */
    public string $password;

    /**
     * Email пользователя.
     *
     * @var string
     */
    public string $email;


    /**
     * Хэш-ключ аутентификации.
     *
     * @var string
     */
    public string $auth_key;

    /**
     * Содержит аттрибуты неоходимые для автозагрузки и
     * валидации свойств экземпляра данного класса.
     *
     * Перечислите те свойства которые должны заполняться при
     * автозагузке и проходить валидацию.
     *
     * @var array
     */
    public array $attributes = [
        'password', 'email', 'rememberMe',
    ];


    /**
     * Правила валидации для формы авторизации.
     *
     * @var array
     */
    public array $rules =  [
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


    /**
     * Авторизует пользователя
     *
     * @return bool
     */
    public function login(): bool
    {
        $userData = User::findOne(User::$tableName, 'email = ?', [$this->email]);
        $attributes = ['password', 'name', 'login', 'auth_key', 'email'];
        $user = User::loadAttrInNewModel($attributes, $userData, new User());
    
        if (!$user->validatePassword($this->password)) {
            $user = null;
            $_SESSION['error-login'] = 'Неправлиьный логин или пароль!';
        }

        if (!$user) {
            throw new \Exception('Пользователь не найден.');
        } else {
            if ($this->rememberMe === false) {
                $_SESSION['user'] = $user;
                $_SESSION['user']->isGuest = false;
            } else {
                setcookie('auth_key', $user->auth_key, time() + 3600 * 24 * 30, '/');
            }
            $_SESSION['success'] = 'Вы успешно авторизировались!';
            return true;
        }
    }
}