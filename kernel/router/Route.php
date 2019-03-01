<?php

namespace StudentsList\Kernel\Router;

/**
 * Класс для построения маршрута
 */
class Route
{
    /**
     * @var string Регулярное выражение для поиска совпадений в URL
     */
    private $pattern;

    /**
     * @var string Контроллер приложения
     */
    private $controller;

    /**
     * @var string Метод контроллера
     */
    private $action;

    public function __construct($pattern, $controller, $action)
    {
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * Возвращает шаблон pattern
     *
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Возвращает имя контроллера
     *
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * Возвращает метод контроллера
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

}