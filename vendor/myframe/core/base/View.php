<?php

namespace myframe\core\base;

use Exception;

class View 
{   
    /**
     * @property array
     * 
     * Свойство с данными клентского кода 
     * которые будут использованны в виде.
     */
    private $data = [];

    /**
     * @property string
     * 
     * Свойство содержащее имя контроллера
     * взятое из массива $route;
     */
    private $controllerName;

    /**
     * @property string
     * 
     * Свойство содержащее название вида которое
     * необходимо отобразить.
     */
    private $view;

    /**
     * Свойство содержащее название
     * шаблона для отображения.
     */
    private $layout;

    /**
     * Префикс роута.
     * 
     * Необходим для разделения роутов на пользовательские
     * и административные.
     */
    private $prefix;

    /**
     * Конструкотр класса.
     * 
     * Загружает данные полученные от базового контроллера в
     * соотвествующие свойства текущего класса.
     */
    public function __construct(string $view, array $data = null, 
        string $controllerName, string $prefix, $layout)
    {
        $this->data = $data;
        $this->controllerName = $controllerName;
        $this->view = $view;
        $this->layout = $layout;
        if ($prefix) {
            $this->prefix = str_replace('\\', '/', $prefix);  
        } else {
            $this->prefix = $prefix;
        }
    }

    /**
     * Базовый метод рендера предствления.
     * 
     * В зависимости от значения свойства $layout
     * вызывает определённый подметод редера.
     */
    public function renderView()
    {   
        if ($this->layout === false) {
            $this->getContent();
        } else {
            $this->getFullView();
        }
    }

    /**
     * Метод вызываемый если свойство $layout 
     * установленно как  false.
     */
    private function getContent()
    {   
        if (is_array($this->data)) {
            extract($this->data);
        }
        $pathToView = APP . "/views/{$this->controllerName}/{$this->view}.php";
        require_once $pathToView;
    }

    /**
     * Метод отображающий полноценный вид с 
     * шаблоном и контентом внутри него.
     */
    private function getFullView()
    {   
        if (is_array($this->data)) {
            extract($this->data);
        }

        $pathToLayout = APP . "/views/layouts/{$this->layout}.php";
        $pathToView = APP . "/views/{$this->prefix}{$this->controllerName}/{$this->view}.php";

        if (file_exists($pathToView)) {
            ob_start();
            require_once $pathToView; 
        } else {
            throw new Exception("Файл вида {$pathToView} не найден", 404);
        }

        if (file_exists($pathToLayout)) {
            $content = ob_get_clean();
            require_once $pathToLayout;
        } else {
            throw new Exception("Шаблон {$pathToLayout} не найден", 404);
        }
    }
    
}