<?php

/**
 * Базовые константы для всего приложения;
 * 
 * 1) ROOT -- Корень фрэймворка;
 * 2) APP -- Папка с основными компонентами MVC приложения;
 * 3) CORE -- Папка с "Движком" фрэймворка;
 * 4) LIBS -- Папка со вспомогательными классами фрэймворка;
 * 5) WEB -- Публичная папка (FrontController, js, css, images и т.д);
 * 6) CONFIG -- Папка с конфигурацией фрэймворка;
 * 7) RUNTIME -- Папка содержащая временные файлы;
 * 8) LAYOUT -- Шаблон видов;
 * 9) DEBUG -- Режим показа ошибок;
 */


define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('CORE', dirname(__DIR__) . '/vendor/myframe/core');
define('LIBS', dirname(__DIR__) . '/vendor/myframe/libs');
define('WEB', dirname(__DIR__) . '/web');
define('CONFIG', dirname(__DIR__) . '/config');
define('RUNTIME', dirname(__DIR__) . '/tmp');
define('LAYOUT', 'default');
define("DEBUG", 1);

require_once ROOT . '/vendor/autoload.php';

$config = require_once CONFIG . '/config.php';

(new \myframe\core\App($config))->run();