<?php

namespace myframe\core;

use myframe\core\Register;
use myframe\core\Router;

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
    private $config;

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
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function run() : void
    {
        self::$components = Register::instance($this->config['components']);
        (new Router($this->config['routes']))->dispatch();
    }
}
