<?php

namespace App\Core;

class Router {
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method) {
        $this->routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function get($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, 'GET');
    }

    public function post($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, 'POST');
    }

    public function patch($route, $controller, $action) {
        $this->addRoute($route, $controller, $action, 'PATCH');
    }

    public function dispatch() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        if(!array_key_exists($method, $this->routes)) {
            header('HTTP/1.0 404 Not Found');
            header('Location: 404.php');
        }

        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            header('HTTP/1.0 404 Not Found');
            //header('Location: 404.php');
            //throw new \Exception('Route not found');
        }
    }
}