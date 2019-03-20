<?php

namespace StudentsList\Kernel\Services;

class RoutesListServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'routes_list';

    public function init()
    {
        $routes = require_once __DIR__ . '/../../config/routes.php';
        $this->di->setDependency($this->serviceName, $routes);
    }
}