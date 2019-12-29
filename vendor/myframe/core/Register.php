<?php

namespace myframe\core;

class Register
{
    private static $instance;

    public static $container = [];

    public function __construct($components)
    {
        foreach ($components as $name => $component)
        {
            self::$container[$name] = $component;
        }
    }

    public static function instance($components)
    {
        if (self::$instance === null) {
            self::$instance = new self($components);
        }
        return self::$instance;
    }

    public function __get($name)
    {
        if (is_object(self::$container[$name])) {
            return self::$container[$name];
        }
    }

    public function __set($name, $object)
    {
        if (!isset(self::$container[$name])) {
            self::$container[$name] = new $object;
        }
    }
}