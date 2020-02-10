<?php

$config = [
    'components' => [
        'user' => 'app\models\User',
        'cache' => 'myframe\core\components\cahce\Cache',
        'request' => 'myframe\core\components\request\Request',
    ],
    'db' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=epframe;charset=utf8',
        'user' => 'alex',
        'password' => 'WGYMBiu63)wdJz`',
    ],
    'routes' => [
        '^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$' => [],
    ],
];

return $config;