<?php

namespace App\Route;

use App\Service\Container;

class Router {
    protected $routes = [];
    protected $container;
    protected $middlewares = [];

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function addRoute($method, $uri, $handler) {
        $this->routes[$method][$uri] = $handler;
    }

    public function addMiddleware($uri, $middleware) {
        $this->middlewares[$uri] = $middleware;
    }

    public function resolve($uri, $method) {
        if (isset($this->routes[$method][$uri])) {
            if (isset($this->middlewares[$uri])) {
                $middleware = $this->middlewares[$uri];
                $middleware->handle($_REQUEST, function() use ($uri, $method) {
                    $handler = $this->routes[$method][$uri];
                    $controller = $this->container->get($handler[0]);
                    $controller->{$handler[1]}($_POST);
                });
            } else {
                $handler = $this->routes[$method][$uri];
                $controller = $this->container->get($handler[0]);
                $controller->{$handler[1]}($_POST);
            }
            return;
        }
        http_response_code(404);
        echo "404 - Route not found";
    }
    
    public function get($uri, $handler) {
        $this->addRoute('GET', $uri, $handler);
    }

    public function post($uri, $handler) {
        $this->addRoute('POST', $uri, $handler);
    }

    public function defineRoutes() {
        $routes = [
            'GET' => [
                '/login' => 'Auth@viewLogin',
                '/createAccount' => 'Auth@viewCreateAccount',
                '/home' => 'Auth@viewHome',
                '/logout' => 'Auth@logout',
            ],
            'POST' => [
                '/login' => 'Auth@login',
                '/createAccount' => 'Auth@createAccount',
                '/home' => 'Auth@viewHome',
                '/logout' => 'Auth@logout',
            ]
        ];

        foreach ($routes as $method => $uris) {
            foreach ($uris as $uri => $action) {
                $actionParts = explode('@', $action);
                $this->addRoute($method, $uri, [$actionParts[0], $actionParts[1]]);
            }
        }
    }
}
