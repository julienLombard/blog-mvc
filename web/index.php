<?php

// Autoloader
require __DIR__.'/../vendor/autoload.php';

use App\Request;
use App\Router\Router;
use App\Router\Route;
use App\ORM\Database;
use App\ORM\Manager;
use Model\Post;

$request = Request::createFromGlobals();

$router = new Router($request);
$router->loadYaml(__DIR__."/../config/routing.yml");

$route = $router->find($request);

$response = $route->call($request, $router);
$response->send();