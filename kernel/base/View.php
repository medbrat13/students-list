<?php

namespace StudentsList\Kernel\Base;


class View
{
    protected $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function render($layout, $viewTemplate, $meta, $data)
    {
        $viewFile = VIEWS . '/' . $this->getControllerName($this->controller) . '/' . $viewTemplate . '.phtml';
        $layoutFile = LAYOUTS . '/' . $layout . '.phtml';

        if (file_exists($viewFile)) {
            ob_start();
            require_once $viewFile;
            $viewContent = ob_get_clean();
        } else {
            $viewContent = '';
            echo "Вид $viewTemplate не найден";
        }

        if (file_exists($layoutFile)) {
            require_once LAYOUTS . '/' . $layout . '.phtml';
        } else {
            echo "Шаблон $layout не найден";
        }
    }

    /**
     * @param $controllerClass
     * @return string
     */
    public function getControllerName($controllerClass): string
    {
        $explodedControllerClass = explode('\\', $controllerClass);
        $controllerFullName = array_pop($explodedControllerClass);
        preg_match('#^[A-Z]+[a-z]+#', $controllerFullName, $match);
        return $match[0];
    }

}