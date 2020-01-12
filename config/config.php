<?php

$config = [
    'components' => [
        'cache' => 'myframe\core\components\Cache',
    ],
    'db' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=epframe;charset=utf8',
        'user' => 'alex',
        'password' => 'WGYMBiu63)wdJz`',
    ],
    'routes' => [
        // =============== USER_ROUTE ========================
        '^foo/?(?P<action>[a-z-]+)?$' => ['controller' => 'main', 'action' => 'index'],
        // =============== DEFAULT_ROUTE =====================
        '^$' => ['controller' => 'main', 'action' => 'index'],
        '^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$' => [],
    ],
];

return $config;