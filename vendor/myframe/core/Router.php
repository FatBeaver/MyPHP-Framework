<?php

namespace myframe\core;

class Router 
{   
    private $queryString;

    private $routes = [];

    private $route = [];

    public function __construct(array $routes)
    {  
        $this->queryString = $_SERVER['QUERY_STRING'];
        $this->routes = $routes;
    }

    private function searchMatchRoute(string $queryString) : bool
    {   
        foreach ($this->routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $queryString, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                    if (!isset($route['action'])) {
                        $route['action'] = 'index';
                    }
                }
                $this->route = $route;
                return true;
            }
        }
        return false;
    }

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

    private function upperCase(string $string) : string
    {
        $string = str_replace('-', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        return $string;
    }

    public function dispatch() : void
    {   
        $this->queryString = $this->sliceQueryString($this->queryString);

        if ($this->searchMatchRoute($this->queryString)) {

            $controllerClass = 'app\\controllers\\' . $this->upperCase($this->route['controller']) 
            . 'Controller';
            $controllerAction = 'action' . $this->upperCase($this->route['action']);

            if (class_exists($controllerClass)) {
                $controllerObject = new $controllerClass;
                if (method_exists($controllerClass, $controllerAction)) {
                    $controllerObject = new $controllerClass;
                    $controllerObject->$controllerAction();
                } else {
                    echo "Метод {$controllerAction} не найден";
                }
            } else {
                echo "Kласс {$controllerClass} не найден";
            }
        } else {
            echo 'Страница не найдена';
        }
    }
}