<?php

namespace myframe\console;

class ConsoleApp 
{   
    /**
     * Конфигурация приложения
     */
    public static array $config = [];

    /**
     * Конструктор загружающий конфинг файл в 
     * паблик св-во $config
     */
    public function __construct($config)
    {
        self::$config = $config;
    }

    /**
     * Метод создающий экземпляр консольного роутера.
     */
    public function run($argv)
    {
        (new ConsoleRouter($argv, self::$config['routes']))->dispatch();
    }
}