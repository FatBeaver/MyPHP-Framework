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
     * Содержит аттрибуты неоходимые для автозагрузки
     * свойств в экземпляр класса.
     *
     * Перечислите те свойства которые должны заполняться при
     * автозагузке.
     *
     * @var array
     */
    public array $attributes = [
        'login', 'password', 'email', 'name', 'rememberMe'
    ];

    /**
     * Возвращает ID текущего экземпляра
     * класса User.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

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
     * @return bool
     */
    public function setPassword(string $password): bool
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
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
        $this->auth_key = random_bytes(10);
    }

    /**
     * Валидирует ключи аутентификации.
     *
     * @param string $auth_key
     *
     * @return bool
     */
    public function validateAuthKey(string $auth_key): bool
    {
        return $this->auth_key === $auth_key;
    }
}