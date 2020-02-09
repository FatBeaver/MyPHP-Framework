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
     * True если пользователь НЕ авторизован.
     * Если пользователь авторизован то False.
     *
     * @var bool
     */
    public bool $isGuest = true;

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
        return password_verify($password, $this->password);
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
     * Удаляет пользователя из сессии а так же
     * его куки $auth_key
     *
     * @return bool
     */
    public static function logout(): bool
    {
        setcookie('auth_key', '', time() - 36000, '/');
        unset($_SESSION['user']);
        return true;
    }
}