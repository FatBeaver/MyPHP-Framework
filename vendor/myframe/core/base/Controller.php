<?php

namespace myframe\core\base;

class Controller
{   
    /**
     * @property array
     * 
     * Содержит данные роута, а именно:
     *   --- Имя Контроллера -- ($this->route['controller'])
     *   --- Имя Действия Контроллера -- ($this->route['action'])
     */
    private $route = [];

    /**
     * Название шаблона для видов.
     * По умолчанию -- 'default'
     * 
     * Может содержать булев тип -- false в случаях когда
     * нужно отобразить вид без шаблона (AJAX). 
     */
    protected $layout = LAYOUT;

    /**
     * Конструктор класса.
     * 
     * Загружает массив с данным о роуте в приватное св-во $route;
     */
    public function __construct(array $route)
    {   
        $this->route = $route;
    }

    /**
     * Перенаправляет пользователя на указанный $url.
     *
     * @param bool|string $url
     */
    protected function redirect($url = false)
    {
        if ($url) {
            $redirect = $url;
        } else {
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/" ;
        }
        header("Location: $redirect");
        exit();
    }

    /**
     * @return void
     * 
     * Метод вызываемый из дочерних контроллеров.
     * Отображает вид с нужным шаблоном или же без него.
     */
    protected function render(string $view, array $data = null) : bool
    {   
        $viewObject = new View($view, $data, $this->route['controller'], 
            $this->route['prefix'], $this->layout);
            
        $viewObject->renderView();
        return true;
    }
}