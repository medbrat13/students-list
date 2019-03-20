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

    public function __construct(string $uri)
    {
        $this->uri = $this->cutGetParams($uri);
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
     * @param $route
     * @return void
     */
    private function setCurrentRoute($route): void
    {
        $this->currentRoute = $route;
    }

    /**
     * Ищет маршрут и заполняет его поля значениями из найденных совпадений $matches,
     * если поля еще не заполнены (например, из-за специфичного описания маршрута в конфиге)
     *
     * @param $routes
     * @param $uri
     * @return Route
     */
    private function findAndPrepareRoute($routes, $uri): Route
    {
        foreach ($routes as $route) {
            $pattern = $route->getPattern();
            if (preg_match("#$pattern#", $uri, $matches)) {
                if ($route->getController() === '' && isset($matches['controller'])) {
                    $route->setController($matches['controller']);
                }

                if ($route->getAction() === '' && isset($matches['action'])) {
                    $route->setAction($matches['action']);
                } else if ($route->getAction() === '') {
                    $route->setAction('index');
                }

                return $route;
            }
        }
    }

    /**
     * Обрезает в адресной строке GET-параметры
     *
     * @param string $uri Адресная строка
     *
     * @return string
     */
    private function cutGetParams($uri): string
    {
        if ($uri) {
            $params = explode('?', $uri, 2);
            if(!strpos($params[0], '=')) {
                return $params[0];
            } else {
                return '';
            }
        }

        return '';
    }

    /**
     * Проверяет, существует ли маршрут
     *
     * @param $routes
     * @param $uri
     * @return bool
     */
    private function routeExists($routes, $uri): bool
    {
        foreach ($routes as $route) {
            $pattern = $route->getPattern();
            if (preg_match("#$pattern#", $uri)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Создает запрос на существование искомого контроллера и экшена и возвращает ответ
     *
     * @param string $controllersPath Путь до котроллеров
     * @return Response Ответ, содержащий имя текущего контроллера и экшена
     * @throws \Exception Исключения в случае, если не найден путь, контроллер или экшен
     */
    public function dispatch($controllersPath): Response
    {
        if (!$this->routeExists($this->routes, $this->uri)) {
            throw new \Exception("Маршрут $this->uri не найден", 404);
        }
        
        $this->setCurrentRoute(
            $this->findAndPrepareRoute($this->routes, $this->uri)
        );

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