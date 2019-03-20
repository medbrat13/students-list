<?php

namespace StudentsList\Kernel\Router;

/**
 * Класс запроса вызова нужного контроллера и экшена
 */
class Request
{
    /**
     * @var string Полный путь до класса-контроллера
     */
    private $controllerPath;

    /**
     * @var string Контроллер
     */
    private $controller = '';

    /**
     * @var string Экшен
     */
    private $action = '';

    public function __construct($controllerPath, $controller, $action)
    {
        $this->controllerPath = $controllerPath;

        if ($this->controllerExists($controller)) {
            $this->controller = $this->prepareController($this->controllerPath, $controller);
        }

        if ($this->actionExists($this->controller, $action)) {
            $this->action = $this->prepareAction($action);
        }
    }

    private function controllerExists($controller): bool
    {
        return class_exists($this->prepareController($this->controllerPath,"$controller"));
    }

    private function actionExists($controller, $action): bool
    {
        return method_exists($controller, $this->prepareAction($action));
    }

    private function prepareController($pathTo, $controller): string
    {
        return $pathTo . str_replace(' ', '', ucwords(str_replace('-', ' ', $controller))) . 'Controller';
    }

    private function prepareAction($action): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $action)))) . 'Action';
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

}