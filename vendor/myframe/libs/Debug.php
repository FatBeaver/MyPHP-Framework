<?php

namespace myframe\core\libs;

class Debug
{
    public static function print($value)
    {
        echo '<pre>' . print_r($value) . '</pre>';
    }
}