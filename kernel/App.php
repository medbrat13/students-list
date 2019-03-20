<?php

namespace StudentsList\Kernel;

class App
{
    /**
     * @var DI
     */
    private $di;

    /**
     * @var Router Роутер приложения
     */
    private $router;

    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->router = $this->di->getDependency('router');

    }

    public function launch(): void
    {
        $controllersPath = 'StudentsList\App\Controllers\\';
        $response = $this->router->dispatch($controllersPath);

        $controllerClass = $response->getController();
        $controllerObj = new $controllerClass($this->di);
        $action = $response->getAction();
        $controllerObj->$action();
        $controllerObj->render(DEFAUT_LAYOUT);
    }
}