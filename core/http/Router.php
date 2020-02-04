<?php

namespace App\Core\Http;

use App\Services\LoggingService;

class Router
{
    /**
     * All registered routes.
     *
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    /**
     * Load a user's routes file.
     *
     * @param string $file
     */
    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Register a PUT route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function put($uri, $controller)
    {
        $this->routes['PUT'][$uri] = $controller;
    }

    /**
     * Register a PATCH route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function patch($uri, $controller)
    {
        $this->routes['PATCH'][$uri] = $controller;
    }

    /**
     * Register a DELETE route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function delete($uri, $controller)
    {
        $this->routes['DELETE'][$uri] = $controller;
    }

    /**
     * Register a resource route(full crud).
     *
     * @param string $uri
     * @param string $controller
     */
    public function resource($baseUri, $controller)
    {
        $this->get("{$baseUri}/showAll", "{$controller}@showAll");
        $this->get("{$baseUri}/create", "{$controller}@create");
        $this->get("{$baseUri}/edit", "{$controller}@edit");
        $this->get("{$baseUri}", "{$controller}@index");
        $this->get("{$baseUri}/findById", "{$controller}@show");
        $this->post("{$baseUri}", "{$controller}@store");
        $this->put("{$baseUri}/update", "{$controller}@update");
        $this->delete("{$baseUri}/delete", "{$controller}@destroy");
    }

    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     */
    public function direct($uri, $requestType)
    {
        if ($this->routeExists($uri, $requestType)) {
            $params = explode('@', $this->routes[$requestType][$uri]);
            return $this->callAction(...$params);
        }
        return abort_view(404);
    }

    protected function routeExists($uri, $requestType)
    {
        return array_key_exists($uri, $this->routes[$requestType]);
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $action
     */
    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (! method_exists($controller, $action)) {
            return abort_view(500, [
                'message' => "Controller does not respond to the {$action} action."
            ]);
        }

        if (!$controller->canAccess($action)) {
            return redirect($controller->redirectPath);
        }

        try {
            return $controller->$action();
        } catch (\Throwable $th) {
            LoggingService::trackError($th->getMessage());
            return abort(500, $th->getMessage());
        }
    }
}
