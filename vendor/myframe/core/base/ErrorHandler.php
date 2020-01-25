<?php

namespace myframe\core\base;

use Exception;

/**
 * Класс ErrorHandler.
 *
 * Экземпляр данного класса создается в методе run()
 * класса \myframe\core\App;
 */
class ErrorHandler
{
    /**
     * Конструктор self класса.
     *
     * Устанавливает режим обработки ошибок в зависимости от значения
     * константы DEBUG.
     *
     * Вызывает основные методы для отлова ошибок в которых ответственность
     * за обработку ошибок передаётся в методы данного класса.
     */
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

    /**
     * Обработчик всех ошибок за исключением фатальных.
     *
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     *
     * @return bool
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {   
        $this->errorLog($errno, $errstr, $errfile, $errline);
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }

    /**
     * Обработчик исключений.
     *
     * @param $e
     *
     * @return bool
     */
    public function exceptionHandler($e): bool
    {   
        $this->errorLog('Exception', $e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Exception', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
        return true;
    }

    /**
     * Обработчик фатальных ошибок.
     *
     * @return bool
     */
    public function fatalErrorHandler(): bool
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

    /**
     * Метод содержащий логику вывода данных об ошибке
     * пользователю.
     *
     * @param  $errno
     * @param  $errstr
     * @param  $errfile
     * @param  $errline
     * @param  $response
     */
    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500): void
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

    /**
     * Метод логирующий ошибки в файл <project_root>/tmp/error/err.log.
     *
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     */
    protected function errorLog($errno, $errstr, $errfile, $errline): void
    {
        error_log("[" . date('d-m-Y H:i:s') . "];
        Текст ошибки: {$errstr};\nФайл ошибки: {$errfile};
        Строка ошибки: {$errline};
        //============================================//\n\n", 3, ROOT . '/tmp/error/err.log');
    }
}