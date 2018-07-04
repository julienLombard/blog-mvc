<?php

// Autoloader
require __DIR__.'/../vendor/autoload.php';

use App\Request;
use App\Router\Router;
use App\Router\Route;

$request = Request::createFromGlobals();

$router = new Router($request);

// Router Test
$router->add(new Route("blog_show", "/blog/:id", ["id" => "\d+"], "blog", "show"));
var_dump($router->find());

$route = $router->find();
$response = $route->call($request, $router); 
var_dump($response);