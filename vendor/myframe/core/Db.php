<?php

namespace myframe\core;

use myframe\core\App;
use \RedBeanPHP\R;

class Db extends \RedBeanPHP\R
{
    private $pdo;

    private static $instance;

    protected function __construct()
    {
        $db = App::$config['db'];
        $this->pdo = R::setup($db['dsn'], $db['user'], $db['password']);
        R::freeze(true);
    } 

    public static function instance() 
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}