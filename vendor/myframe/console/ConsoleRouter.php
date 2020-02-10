<?php

namespace myframe\console;

class ConsoleRouter 
{   
    /**
     * Пользовательский запрос в консоли.
     */
    private string $userQuery;

    /**
     * Параметры пользовательского запроса.
     */
    private string $userArguments;

    /**
     * Массив роутов для консольного приложения
     */
    private array $routes = [];

    /**
     * Текущий роут с которым найдено совпание.
     */
    private array $currentRoute = [];

    /**
     * Конструктор консольного роутера.
     */
    public function __construct($argv, $routes)
    {   
        $this->routes = $routes;

        $this->userQuery = $argv[1];
        if (isset($argv[2]) && !empty($argv[2])) {
            $this->userArguments = $argv[2];
        }
    }

    /**
     * Функция поиска совпадения запроса пользовтеля
     * и имеющихся маршрутов.
     */
    private function searchMatchesRoute(): bool
    {   
        foreach ($this->routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $this->userQuery, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                    if (!isset($route['action'])) {
                        $route['action'] = 'index';
                    }
                }
                $this->currentRoute = $route;
                return true;
            }
        }
        return false;
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
     * Метод поднимающий контроллер исходя из роута и запускающий
     * действие созданного контроллера.
     */
    public function dispatch()
    {
        if ($this->searchMatchesRoute()) {

            $controllerClass = "console\\controllers\\" . 
                $this->upperCase($this->currentRoute['controller']) . "Controller";
            $controllerAction = "action" . $this->upperCase($this->currentRoute['action']);
    
            if (class_exists($controllerClass)) {
                $controllerObject = new $controllerClass();
                if (method_exists($controllerClass, $controllerAction)) {
                    $controllerObject->$controllerAction($this->userArguments);
                } else {
                    exit("Действие {$controllerAction} не найдено." . PHP_EOL);
                }
            } else {
                exit("Контроллер {$controllerClass} не найден." . PHP_EOL);
            }
        } else {
            exit("Не корректная комманда." . PHP_EOL);
        }
    }
}