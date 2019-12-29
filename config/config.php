<?php

$config = [
    'components' => [
        'cache' => 'myframe\core\components\Cache',
    ],
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=myframe;charset=utf8',
        'user' => 'alex',
        'password' => 'WGYMBiu63)wdJz`',
    ],
    'routes' => [
        '^foo/?(?P<action>[a-z-]+)?$' => ['controller' => 'main', 'action' => 'index'],
        // =============== DEFAULT_ROUTE =====================
        '^$' => ['controller' => 'main', 'action' => 'index'],
        '^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$' => [],
    ],
    'error' => [
        'errorHandlerClass' => 'myframe\core\base\ErrorHandler',
    ],
];

return $config;