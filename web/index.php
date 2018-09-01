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
$router->add(new Route("admin", "/admin", [], "Controller\AdminController", "showData"));
$router->add(new Route("admin_posts", "/admin/posts\?page=:page", ["page" => "\d+"], "Controller\AdminController", "postsList"));
$router->add(new Route("admin_post", "/admin/post/:id", ["id" => "\d+"], "Controller\AdminController", "showAdminPost"));
$router->add(new Route("admin_create_post_form", "/admin/create-post-form", [], "Controller\AdminController", "createPostForm"));
$router->add(new Route("admin_create_post", "/admin/create-post", [], "Controller\AdminController", "createPost"));
$router->add(new Route("admin_edit_post", "/admin/edit-post/:id", ["id" => "\d+"], "Controller\AdminController", "showEditPost"));
$router->add(new Route("admin_update_post", "/admin/update-post/:id", ["id" => "\d+"], "Controller\AdminController", "updatePost"));
$router->add(new Route("admin_confirm_delete_post", "/admin/confirm-delete-post/:id", ["id" => "\d+"], "Controller\AdminController", "confirmDeletePost"));
$router->add(new Route("admin_delete_post", "/admin/delete-post/:id", ["id" => "\d+"], "Controller\AdminController", "deletePost"));

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