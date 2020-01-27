<?php

namespace app\models;

use myframe\core\base\Model;
use myframe\core\components\user\UserIdentityInterface;

class User extends Model implements UserIdentityInterface
{
    /**
     * Имя таблицы в БД.
     *
     * @var string
     */
    public static string $tableName = 'user';

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
    public array $rulesForSignUp = [
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
     * Правила валидации для формы авторизации.
     *
     * @var array
     */
    public array $rulesForLogin =  [
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
     * Возвращает состояние пользователя.
     *
     * @return bool
     */
    public function isGuest(): bool
    {
        return $this->isGuest;
    }

    /**
     * Создает хэш пароля.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Валидирует пароль полученный от пользователя при заполнении
     * формы и пароль из БД.
     *
     * @param string $password
     *
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return password_verify($this->password, $password);
    }

    /**
     * Получение экземпляра Класса User по
     * Email введёному пользователем в форме.
     *
     * @param string $email
     *
     * @return object
     */
    public static function getByEmail(string $email): object
    {
        return User::findOne('user', 'email = ?', [$email]);
    }

    /**
     * Получение экземпляра Класса User по
     * login введёному пользователем в форме.
     *
     * @param string $login
     *
     * @return object
     */
    public static function getByLogin(string $login): object
    {
        return User::findOne('user', 'login = ?', [$login]);
    }

    /**
     * Генерированиние ключа аутентификации.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function generateAuthKey(): string
    {
        $this->auth_key = md5($this->email . $this->password . $this->name . time() . rand(0, 1000));
        return $this->auth_key;
    }


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
        $this->setPassword($this->password);
        $newUser->password = $this->password;
        $newUser->auth_key = $this->generateAuthKey();

        if (User::store($newUser)) {
            if ($this->rememberMe === false) {
                $_SESSION['user'] = User::findOne(User::$tableName, 'id = ?', [$newUser->id]);
                $_SESSION['user']->changeUserStatus();
            } else {
                setcookie('auth_key', $this->auth_key, time() + 3600 * 24 * 30, '/');
            }
            $_SESSION['success'] = 'Вы успешно прошли регистрацию!';
            return true;
        } else {
            throw new \Exception('Ошибка. Регистрация не удалась, повторите попытку пойзже.');
            return false;
        }

    }

    /**
     * Авторизует пользователя
     *
     * @return bool
     */
    public function login(): bool
    {
        $user = User::findOne(User::$tableName, 'email = ?', [$this->email]);

        if (!$this->validatePassword($user->password)) {
            $user = null;
            $_SESSION['error-login'] = 'Неправлиьный логин или пароль!';
        }

        if (!$user) {
            throw new \Exception('Пользователь не найден.');
        } else {
            if ($this->rememberMe === false) {
                $_SESSION['user'] = $user;
                $_SESSION['user']->changeUserStatus();
            } else {
                setcookie('auth_key', $user->auth_key, time() + 3600 * 24 * 30, '/');
            }
            $_SESSION['success'] = 'Вы успешно авторизировались!';
            return true;
        }
    }

    /**
     * Удаляет пользователя из сессии а так же
     * его куки $auth_key
     *
     * @return bool
     */
    public function logout(): bool
    {
        setcookie('auth_key', '', time() - 36000, '/');
        unset($_SESSION['user']);
        return true;
    }
}