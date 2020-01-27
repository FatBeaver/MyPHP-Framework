<?php

namespace myframe\core;

use Exception;

class Router 
{   
    /**
     * @property string
     * 
     * Свойство содержащее строку запроса;
     */
    private $queryString;

    /**
     * @property array
     * 
     * Свойство содержащее массив маршрутов из файла 
     * конфигурации;
     */
    private $routes = [];

    /**
     * @property array
     * 
     * Свойство содержащее массив данных 
     * необходимых для создания экзепляра класса Контроллера и 
     * и запуска его Действия;
     */
    private $route = [];

    public function __construct(array $routes)
    {  
        $this->queryString = $_SERVER['QUERY_STRING'];
        $this->routes = $routes;
    }

    /**
     * @return bool
     * 
     * Метод проходит в цикле по всем маршрутам и ищет совпадения со
     * строкой запроса. В случае успеха присваивает имя Контроллера и Действия
     * в свойство класса (массив)$this->route и возвращает TRUE;
     *
     * Заполняет массив $_GET параметрами исходя из шаблона рег. выражения.
     *
     * Если совпадений маршрутов со строкой запроса не найденно метод вернёт FALSE;
     */
    private function searchMatchRoute(string $queryString) : bool
    {   
        foreach ($this->routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $queryString, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        if (($key != 'action') && ($key != 'controller')) {
                            $_GET[$key] = $value;
                        }
                        $route[$key] = $value;
                    }
                }

                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }

                $this->route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     * 
     * Метод обрезает строку от "явных" GET параметров;
     * Необходимо для корректного заполнения массива $this->route;
     */
    private function sliceQueryString(string $queryString) : string
    {   
        if ($queryString) {
            $queryString = explode('&', $queryString);
            if (strpos($queryString[0], '=') === false) {
                return $queryString[0];
            } else {
                return '';
            }
        }
        return $queryString;
    }

    /**
     * @return string
     *  
     * Убирает дефисы из названий контроллеров и дейсвтий;
     * 
     * Первый символ каждого слова в строке переводит в 
     * верхний регистр; 
     */
    private function upperCase(string $string) : string
    {
        $string = str_replace('-', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        return $string;
    }

    /**
     * @return void
     * 
     * Метод создает экземпляр класса Контроллера исходя из 
     * сходства маршрутов со строкой запроса;
     * 
     * Запускает Действие контроллера;
     */
    public function dispatch() : void
    {   
        $this->queryString = $this->sliceQueryString($this->queryString);

        if ($this->searchMatchRoute($this->queryString)) {

            $controllerClass = 'app\\controllers\\' . $this->route['prefix'] 
            . $this->upperCase($this->route['controller']) . 'Controller';
            
            $controllerAction = 'action' . $this->upperCase($this->route['action']);

            if (class_exists($controllerClass)) {
                $controllerObject = new $controllerClass($this->route);
                if (method_exists($controllerClass, $controllerAction)) {
                    $controllerObject->$controllerAction();
                } else {
                    throw new Exception("Метод {$controllerAction} не найден", 404);
                }
            } else {
                throw new Exception("Kласс {$controllerClass} не найден", 404);
            }
        } else {
            throw new Exception("Страница не найдена", 404);
        }
    }
}