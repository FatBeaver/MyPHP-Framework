<?php

namespace myframe\core\base;

use myframe\core\Db;

class Model extends Db
{
    public function __construct()
    {
        Db::instance();
    }
}