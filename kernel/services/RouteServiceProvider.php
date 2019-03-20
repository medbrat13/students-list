<?php

namespace StudentsList\Kernel\Services;

use StudentsList\Kernel\Router\Route;

class RouteServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'route';

    /**
     * Создает сервис
     *
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        $this->di->setDependency('route', function (string $pattern, string $controller, string $action) {
            return new Route($pattern, $controller, $action);
        });
    }
}