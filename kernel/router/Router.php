<?php

namespace StudentsList\Kernel\Router;

/**
 * Класс маршрутизации
 */
class Router
{

    /**
     * @var Route Текущий маршрут
     */
    private $currentRoute;

    /**
     * @var array Список маршрутов
     */
    private $routes = [];

    /**
     * @var string URI
     */
    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Добавляет маршрут в массив
     *
     * @param Route $route
     */
    public function addRoute(Route $route): void
    {
        array_push($this->routes, $route);
    }

    /**
     * Возвращает текущий маршрут
     *
     * @return Route
     */
    public function getCurrentRoute(): Route
    {
        return $this->currentRoute;
    }

    /**
     * Устанавливает текущий маршрут
     *
     * @param $routes
     * @param $uri
     */
    public function setCurrentRoute($routes, $uri): void
    {
        $this->currentRoute = $this->findRoute($routes, $uri);
    }

    /**
     * Ищет маршрут
     *
     * @param $routes
     * @param $uri
     * @return Route
     */
    private function findRoute($routes, $uri): Route
    {
        foreach ($routes as $route) {
            if ($this->findMatch($route->getPattern(), $uri)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Ищет совпадения
     *
     * @param string $pattern Шаблон
     * @param string $uri URI
     * @return bool
     */
    private function findMatch(string $pattern, string $uri): bool
    {
        return preg_match("#$pattern#", $uri) ? true : false;
    }


    public function dispatch($controllersPath): Response
    {
        $this->setCurrentRoute($this->routes, $this->uri);

        if ($this->getCurrentRoute() === null) {
            throw new \Exception("Маршрут $this->uri не найден", 404);
        }

        $request = new Request($controllersPath,
            $this->getCurrentRoute()->getController(), $this->getCurrentRoute()->getAction());

        if ($request->getController() === '') {
            $notFoundedController = $this->getCurrentRoute()->getController();
            throw new \Exception("Контроллер $notFoundedController не найден", 404);
        }

        if ($request->getAction() === '') {
            $notFoundedAction = $this->getCurrentRoute()->getAction();
            throw new \Exception("Экшен $notFoundedAction не найден", 404);
        }

        $controller = $request->getController();
        $action = $request->getAction();

        return new Response($controller, $action);
    }
}