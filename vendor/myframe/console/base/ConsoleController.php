<?php

namespace myframe\console\base;

use myframe\console\ConsoleApp;

class ConsoleController 
{   
    protected object $pdo;

    public function __construct()
    {   
        $db = ConsoleApp::$config['db'];
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}