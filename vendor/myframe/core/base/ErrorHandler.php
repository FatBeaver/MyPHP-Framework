<?php

namespace myframe\core\base;

use Exception;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG === 1) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {   
        $this->errorLog($errno, $errstr, $errfile, $errline);
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }

    public function exceptionHandler($e)
    {   
        $this->errorLog('Exception', $e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Exception', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
        return true;
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | 
        E_CORE_ERROR)) {
            ob_end_clean();
            $this->errorLog($error['type'], $error['message'], $error['file'], $error['line']);
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        }
        return true;
    }


    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response);
        if ($response == 404 && DEBUG === 0) {
            require_once WEB . '/errors/not_found.php';
            die;
        }
        if (DEBUG === 1) {
            require_once WEB . '/errors/development.php';
        } else {
            require_once WEB . '/errors/production.php';
        }
        die;
    }

    protected function errorLog($errno, $errstr, $errfile, $errline) 
    {
        error_log("[" . date('d-m-Y H:i:s') . "];
        Текст ошибки: {$errstr};\nФайл ошибки: {$errfile};
        Строка ошибки: {$errline};
        //============================================//\n\n", 3, ROOT . '/tmp/error/err.log');
    }
}