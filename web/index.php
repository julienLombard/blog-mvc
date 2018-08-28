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

// Router Test
$router->add(new Route("show_post", "/post/:id", ["id" => "\d+"], "Controller\PostController", "showPost"));
$router->add(new Route("home", "/", [], "Controller\HomeController", "index"));

$route = $router->find();
$response = $route->call($request, $router);
$response->send();

// $database = new Database("localhost","dev_blog", "root","");
// $post = new Post();
// $post->setId(1);
// $post->setTitle("mon titre remis à jour");
// $post->setPicture("ma picture mis à jour");
// $post->setContent("mon contenu mis à jour");
// $post->setPublicationDate( new \DateTime());
// $post->setModificationDate( new \DateTime());

// $manager = $database->getManager(Post::class);
// echo "<pre>";
// $manager->update($post);

// $post = $manager->find(1);
// $post->setTitle("wwwTest");
// $post->setModificationDate(new \DateTime());
// $manager->update($post);

// $posts = $manager->findAll(0,6, "publicationDate", "DESC");
// var_dump($posts);