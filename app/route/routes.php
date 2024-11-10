<?php

use App\Route\Router;
use App\Route\Middleware;
use App\Service\Container;

$container = new Container();

$container->set('Auth', new \App\Controller\Auth($container));

$router = new Router($container);

$router->defineRoutes();

$router->addMiddleware('/home', new Middleware());

return $router;
