<?php

namespace StudentsList\Kernel\Router;

/**
 * Класс ответа вызова нужного контроллера и экшена
 */
class Response
{
    /**
     * @var string Контроллер
     */
    private $controller;

    /**
     * @var string Экшен
     */
    private $action;

    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
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