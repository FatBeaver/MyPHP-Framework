<?php

namespace myframe\core;

use myframe\core\App;
use \RedBeanPHP\R;

/**
 * @class Db
 *
 * Класс реализованный по паттерну синглтон.
 *
 * Метод класса getInstance() возвращает экземпляр
 * класса подключения к БД.
 */
class Db extends \RedBeanPHP\R
{
    private $pdo;

    private static $instance;

    /**
     * Конструктор self класса.
     */
    protected function __construct()
    {
        $db = App::$config['db'];
        $this->pdo = R::setup($db['dsn'], $db['user'], $db['password']);
        R::freeze(true);
    }

    /**
     * Метод возвращающий экземпляр подключения к БД.
     *
     * @return Db
     */
    public static function connect()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}