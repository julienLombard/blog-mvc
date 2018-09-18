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
$router->add(new Route("home", "/", [], "Controller\HomeController", "index"));
$router->add(new Route("home_portfolio", "/#portfolio", [], "Controller\HomeController", "index"));
$router->add(new Route("home_show_post", "/post/:id\?page=:page", ["id" => "\d+", "page" => "\d+"], "Controller\HomeController", "showPost"));
$router->add(new Route("home_create_comment", "/create-comment-post/:id", ["id" => "\d+"], "Controller\HomeController", "createComment"));
$router->add(new Route("admin_connection", "/connection", [], "Controller\AdminController", "connection"));
$router->add(new Route("admin_logout", "/logout", [], "Controller\AdminController", "logout"));
$router->add(new Route("admin", "/admin", [], "Controller\AdminController", "showData"));
$router->add(new Route("admin_posts", "/admin/posts\?page=:page", ["page" => "\d+"], "Controller\AdminController", "postsList"));
$router->add(new Route("admin_post", "/admin/post/:id", ["id" => "\d+"], "Controller\AdminController", "showAdminPost"));
$router->add(new Route("admin_create_post_form", "/admin/create-post-form", [], "Controller\AdminController", "createPostForm"));
$router->add(new Route("admin_create_post", "/admin/create-post", [], "Controller\AdminController", "createPost"));
$router->add(new Route("admin_edit_post", "/admin/edit-post/:id", ["id" => "\d+"], "Controller\AdminController", "showEditPost"));
$router->add(new Route("admin_update_post", "/admin/update-post/:id", ["id" => "\d+"], "Controller\AdminController", "updatePost"));
$router->add(new Route("admin_confirm_delete_post", "/admin/confirm-delete-post/:id", ["id" => "\d+"], "Controller\AdminController", "confirmDeletePost"));
$router->add(new Route("admin_delete_post", "/admin/delete-post/:id", ["id" => "\d+"], "Controller\AdminController", "deletePost"));
$router->add(new Route("admin_comments_list", "/admin/comments\?page=:page", ["page" => "\d+"], "Controller\AdminController", "commentsList"));
$router->add(new Route("admin_show_comments", "/admin/comments-post/:id\?page=:page", ["id" => "\d+", "page" => "\d+"], "Controller\AdminController", "showComments"));
// $router->add(new Route("admin_validate_comment", "/admin/validate-comment/:id\?post=:post&page=:page", ["id" => "\d+"], "Controller\AdminController", "validateComment"));
$router->add(new Route("admin_validate_comment", "/admin/validate-comment/:id", ["id" => "\d+"], "Controller\AdminController", "validateComment"));
$router->add(new Route("admin_edit_comment", "/admin/edit-comment/:id", ["id" => "\d+"], "Controller\AdminController", "showEditComment"));
$router->add(new Route("admin_update_comment", "/admin/update-comment/:id", ["id" => "\d+"], "Controller\AdminController", "updateComment"));
$router->add(new Route("admin_confirm_delete_comment", "/admin/confirm-delete-comment/:id", ["id" => "\d+"], "Controller\AdminController", "confirmDeleteComment"));
$router->add(new Route("admin_delete_comment", "/admin/delete-comment/:id", ["id" => "\d+"], "Controller\AdminController", "deleteComment"));
$router->add(new Route("reported_comment", "/reported-comment/:id", ["id" => "\d+"], "Controller\HomeController", "reportedComment"));
$router->add(new Route("admin_moderate_comment", "/admin/moderate-comment/:id", ["id" => "\d+"], "Controller\AdminController", "moderateComment"));

$route = $router->find();
$response = $route->call($request, $router);
$response->send();