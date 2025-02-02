<?php
namespace Core;

class Router {
    private $routes = [];

    public function get($uri, $controllerMethod) {
        $this->routes['GET'][$uri] = $controllerMethod;
    }

    public function post($uri, $controllerMethod) {
        $this->routes['POST'][$uri] = $controllerMethod;
    }

    public function dispatch($uri) {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            list($controllerName, $methodName) = explode('@', $this->routes[$method][$uri]);

            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
