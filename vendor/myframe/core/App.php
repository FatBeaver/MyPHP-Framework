<?php

namespace myframe\core;

use app\models\User;
use myframe\core\Register;
use myframe\core\Router;
use myframe\core\base\ErrorHandler;
use myframe\libs\debug\Debug;

/**
 * Основной класс фреймворка, экземпляр которого создается во
 * фронт контроллере.
 * 
 * Данный класс отвечает за сборку и подключение основных модулей и компонентов 
 * фрэймворка исходя из загруженного в него файла конфигурации.
 */

class App 
{
    /**
     * @property array
     * 
     * Файл конфигурации фреймворка;
     */
    public static $config;

    /**
     * @property array
     * 
     * Массив компонентов фреймворка;
     */
    public static $components = [];

    /**
     * @return void
     * 
     * Конструктор класса;
     * Загружает массив конфигурации в приватное свойство $this->config;
     *
     * Открывает сессию.
     */
    public function __construct(array $config)
    {
        session_start();
        self::$config = $config;
    }

    /**
     * Авторизация пользователя по куки файлу
     * auth_key
     *
     * @return void
     */
    private function authByCookie(): void
    {
        Db::connect();
        $userData = User::findOne(
            User::$tableName,
            'auth_key = ?',
            [$_COOKIE['auth_key']],
        );
        Db::close();
        $attributes = ['password', 'name', 'login', 'auth_key', 'email'];
        $_SESSION['user'] = User::loadAttrInNewModel($attributes, $userData, new User());
        $_SESSION['user']->isGuest = false;
        self::$components->container['user'] = $_SESSION['user'];
    }

    /**
     * Авторизация пользователя по данным из сессии.
     *
     * @return void
     */
    private function authBySession(): void
    {
        self::$components->container['user'] = $_SESSION['user'];
        //Debug::print(self::$components->user); die;
    }

    /**
     * @return void
     * 
     * Метод запускающий "Движок" фрэймворка:
     * 
     * Создает экземпляр класса Register и загружает его в свойство $this->components;
     * Создает экземпляр класса ErrorHandler;
     * Создает экземпляр класса Router и запускает его метод dispatch();
     */
    public function run() : void
    {
        new ErrorHandler();

        self::$components = Register::instance(self::$config['components']);

        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $this->authBySession();
        } elseif (isset($_COOKIE['auth_key'])) {
            $this->authByCookie();
        }

        (new Router(self::$config['routes']))->dispatch();
    }
}
