<?php

namespace app\models;

use myframe\core\base\Model;

class SignUpForm extends Model 
{   
    /**
     * Флаг для создания auth_key
     *
     * @var bool
     */
    public bool $rememberMe = false;

    /**
     * Логин пользователя.
     *
     * @var string
     */
    public string $login;

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
     * Имя пользователя.
     *
     * @var string
     */
    public string $name;

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
        'login', 'password', 'email', 'name', 'rememberMe',
    ];


    /**
     * Правила валидации данных для
     * формы регистрации.
     *
     * @var array
     */
    public array $rules = [
        'required' => [
            ['login'], ['password'], ['email'], ['name'],
        ],
        'lengthMin' => [
            ['password', 6],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMax' => [
            ['name', 255]
        ]
    ];

    /**
     * Регистрирует пользователя
     *
     * @return bool
     */
    public function signUp(): bool
    {   
        $newUser = User::dispense(User::$tableName);
        $newUser->login = $this->login;
        $newUser->name = $this->name;
        $newUser->email = $this->email;
        $newUser->password = password_hash($this->password, PASSWORD_DEFAULT);
        $newUser->auth_key = md5(pow(rand(1, 1000), rand(0, 10)) . time());

        if (User::store($newUser)) {
            if ($this->rememberMe === false) {
                $userData = User::findOne(User::$tableName, 'id = ?', [$newUser->id]);
                $attributes = ['password', 'name', 'login', 'auth_key', 'email'];
                $_SESSION['user'] = User::loadAttrInNewModel($attributes, $userData, new User());
                $_SESSION['user']->isGuest = false;
            } else {
                setcookie('auth_key', $newUser->auth_key, time() + 3600 * 24 * 30, '/');
            }
            $_SESSION['success'] = 'Вы успешно прошли регистрацию!';
            return true;
        } else {
            throw new \Exception('Ошибка. Регистрация не удалась, повторите попытку пойзже.');
            return false;
        }
    }
}