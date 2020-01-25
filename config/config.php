<?php

$config = [
    'components' => [
        'user' => 'app\models\User',
        'cache' => 'myframe\core\components\cahce\Cache',
    ],
    'db' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=epframe;charset=utf8',
        'user' => 'alex',
        'password' => 'WGYMBiu63)wdJz`',
    ],
    'routes' => [
        // =============== USER_ROUTE ========================
        '^foo/?(?P<action>[a-z-]+)?$' => ['controller' => 'main', 'action' => 'index'],

        // =============== ADMIN_ROUTE =======================
        '^admin-panel$' => ['controller' => 'user', 'action' => 'index', 'prefix' => 'admin'],
        '^admin-panel/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$' => ['prefix' => 'admin'],

        // =============== DEFAULT_ROUTE =====================
        '^$' => ['controller' => 'main', 'action' => 'index'],
        '^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$' => [],
    ],
];

return $config;