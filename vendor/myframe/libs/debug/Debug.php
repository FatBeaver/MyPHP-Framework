<?php

namespace myframe\libs\debug;

class Debug
{
    public static function print($value)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }
}