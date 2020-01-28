<?php
declare(strict_types = 1);

namespace myframe\core\components\request;

/**
 * Класс работающий с основными суперглобальными
 * массивами.
 */
class Request
{
    /**
     * Возвращает данные из массива $_POST
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function post(string $key = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key];
    }

    /**
     * Возвращает данные из массива $_GET
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function get(string $key = null)
    {
        if ($key === null) {
            array_shift($_GET);
            return $_GET;
        }
        return $_GET[$key];
    }

    /**
     * Возвращает данные из массива $_COOKIE
     *
     * @param string|null $key
     *
     * @return mixed
     */
    public function cookie(string $key = null)
    {
        if ($key === null) {
            return $_COOKIE;
        }
        return $_COOKIE[$key];
    }

    /**
     * Удаляет куки.
     *
     * @param string $key
     *
     * @return Request
     */
    public function deleteCookie(string $key): Request
    {
        setcookie($key, "", time() - 3600000, '/');
        return $this;
    }
}
