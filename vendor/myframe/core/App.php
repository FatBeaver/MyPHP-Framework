<?php

namespace myframe\core;

use app\models\User;
use myframe\core\Register;
use myframe\core\Router;
use myframe\core\base\ErrorHandler;

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
     */
    public function __construct(array $config)
    {
        session_start();
        self::$config = $config;
    }

    private function authByCookie()
    {
        self::$components->user = User::findOne(
            User::$tableName,
            'auth_key = ?',
            [$_COOKIE['auth_key']],
        );
        $_SESSION['user']['auth_key'] = $_COOKIE['auth_key'];
        self::$components->user->isGuest = false;
    }

    private function authBySession()
    {
        self::$components->user = User::findOne(
            User::$tableName,
            'auth_key = ?',
            [$_SESSION['user']['auth_key']],
        );
        self::$components->user->isGuest = false;
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

        if (isset($_SESSION['user']['auth_key'])) {
            $this->authBySession();
        } elseif (isset($_COOKIE['auth_key'])) {
            $this->authByCookie();
        }

        (new Router(self::$config['routes']))->dispatch();
    }
}
