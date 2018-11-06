<?php

// Autoloader
require __DIR__.'/../vendor/autoload.php';

use App\Request;
use App\Router\Router;
use App\Router\Route;

// Request
$request = Request::createFromGlobals();

// Router
$router = new Router($request);
$router->loadYaml(__DIR__."/../config/routing.yml");

$route = $router->find($request);

// Response
$response = $route->call($request, $router);
$response->send();