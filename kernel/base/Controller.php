<?php

namespace StudentsList\Kernel\Base;

use StudentsList\Kernel\DB\Connection;
use StudentsList\Kernel\DI;

abstract class Controller
{
    /**
     * @var DI
     */
    protected $di;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string Текущий контроллер
     */
    protected $controller;

    /**
     * @var string Общий шаблон
     */
    protected $layout;

    /**
     * @var array Мета-данные
     */
    protected $meta = [];

    /**
     * @var array Данные
     */
    protected $data = [];

    /**
     * @var View Объект представления
     */
    protected $view;

    /**
     * @var string Шаблон представления
     */
    protected $viewTemplate;

    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->connection = $this->di->getDependency('connection');
        $this->controller = get_class($this);
    }

    /**
     * Показывает пользователю отрисованную во View страницу
     *
     * @param null|string $layout Общий шаблон для всех страниц,
     * можно не передавать, а определить нужный шаблон в нужном контроллере
     */
    public function render($layout = null): void
    {
        $this->view = new View($this->controller);

        if ($layout !== null) {
            $this->layout = $layout;
        }

        $this->view->render($this->layout, $this->viewTemplate, $this->meta, $this->data);
    }

    /**
     * Устанавливает значения мета-данных
     *
     * @param string $title Тег <title></title>
     * @param string $desc Тег <meta name="description" />
     * @param string $keywords Тег <meta name="keywords" />
     * @return void
     */
    protected function setMeta(string $title = '', string $desc = '', string $keywords = ''): void
    {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }

    /**
     * Устанавливает данные для передачи. Можно использовать многократно для установки различных данных.
     *
     * @param array $data Данные
     */
    protected function setData(array $data): void
    {
        $this->data = $this->addData($this->data, $data);
    }

    /**
     * Добавляет массив данных в массив-контейнер
     *
     * @param array $container
     * @param array $data
     * @return array
     */
    protected function addData(array $container, array $data): array
    {
        return array_merge($container, $data);
    }


}