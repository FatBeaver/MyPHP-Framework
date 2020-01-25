<?php

namespace myframe\core;

class Register
{
    private static $instance;

    public $container = [];

    public function __construct($components)
    {
        foreach ($components as $name => $component)
        {
            $this->container[$name] = $component;
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
        $component = new $this->container[$name];

        if (is_object($component)) {
            return $component;
        } else {
            throw new \Exception("Компонент {$component} не является объектом.", 500);
        }
    }

    public function __set($name, $object)
    {
        if (!isset($this->container[$name])) {
            $this->container[$name] = new $object;
        }
    }
}