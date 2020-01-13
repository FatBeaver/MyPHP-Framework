<?php

namespace myframe\core;

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
        self::$config = $config;
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
        
        (new Router(self::$config['routes']))->dispatch();
    }
}
