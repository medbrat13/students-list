<?php

namespace StudentsList\Kernel\Services;

use StudentsList\Kernel\Router\Router;

class RouterServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'router';

    /**
     * Создает сервис
     *
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $routes = $this->di->getDependency('routes_list');
        $routeObj = $this->di->getDependency('route');
        $router = new Router($uri);

        # добавляем маршруты
        foreach ($routes as $pattern => $route) {
            $router->addRoute(
                $routeObj($pattern, $route['controller'], $route['action'])
            );
        }
        $this->di->setDependency($this->serviceName, $router);
    }
}