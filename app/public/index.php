<?php

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

$router = require_once __DIR__ . '/../route/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->resolve($uri, $method);
