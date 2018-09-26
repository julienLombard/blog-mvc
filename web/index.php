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

// Router Test
// $router->add(new Route("home", "/home", [], "Controller\HomeController", "index", false));
// $router->add(new Route("home_posts_list", "/posts", [], "Controller\HomeController", "postsList", false));
// $router->add(new Route("home_post_show", "/post/:id", ["id" => "\d+"], "Controller\HomeController", "showPost", false));
// $router->add(new Route("home_comment_create", "/create-comment-post/:id", ["id" => "\d+"], "Controller\HomeController", "createComment", false));
// $router->add(new Route("home_comment_reported", "/reported-comment/:post/:id", ["post" => "\d+", "id" => "\d+"], "Controller\HomeController", "reportedComment", false));
// $router->add(new Route("home_send_mail", "/home-send-mail", [], "Controller\HomeController", "sendMail", false));

// $router->add(new Route("admin", "/admin", [], "Controller\AdminController", "showData", false));
// $router->add(new Route("admin_user_connection", "/connection", [], "Controller\AdminController", "connection", false));
// $router->add(new Route("admin_user_logout", "/logout", [], "Controller\AdminController", "logout", true));

// $router->add(new Route("admin_posts_list", "/admin/posts", [], "Controller\AdminController", "postsList", true));
// $router->add(new Route("admin_post_show", "/admin/post/:id", ["id" => "\d+"], "Controller\AdminController", "showAdminPost", true));
// $router->add(new Route("admin_post_create_form", "/admin/create-post-form", [], "Controller\AdminController", "createPostForm", true));
// $router->add(new Route("admin_post_create", "/admin/create-post", [], "Controller\AdminController", "createPost", true));
// $router->add(new Route("admin_post_edit", "/admin/edit-post/:id", ["id" => "\d+"], "Controller\AdminController", "showEditPost", true));
// $router->add(new Route("admin_post_update", "/admin/update-post/:id", ["id" => "\d+"], "Controller\AdminController", "updatePost", true));
// $router->add(new Route("admin_post_confirm_delete", "/admin/confirm-delete-post/:id", ["id" => "\d+"], "Controller\AdminController", "confirmDeletePost", true));
// $router->add(new Route("admin_post_delete", "/admin/delete-post/:id", ["id" => "\d+"], "Controller\AdminController", "deletePost", true));

// $router->add(new Route("admin_comments_list", "/admin/comments", [], "Controller\AdminController", "commentsList", true));
// $router->add(new Route("admin_comments_show", "/admin/comments-post/:id", ["id" => "\d+"], "Controller\AdminController", "showComments", true));
// $router->add(new Route("admin_comments_show_invalidated", "/admin/show-invalidated", [], "Controller\AdminController", "showInvalidated", true));
// $router->add(new Route("admin_comments_show_reported", "/admin/show-reported", [], "Controller\AdminController", "showReported", true));
// $router->add(new Route("admin_comment_validate", "/admin/validate-comment/:post/:id", ["post" => "\d+", "id" => "\d+"], "Controller\AdminController", "validateComment", true));
// $router->add(new Route("admin_comment_moderate", "/admin/moderate-comment/:id", ["id" => "\d+"], "Controller\AdminController", "moderateComment", true));
// $router->add(new Route("admin_comment_edit", "/admin/edit-comment/:post/:id", ["post" => "\d+", "id" => "\d+"], "Controller\AdminController", "showEditComment", true));
// $router->add(new Route("admin_comment_update", "/admin/update-comment/:post/:id", ["post" => "\d+", "id" => "\d+"], "Controller\AdminController", "updateComment", true));
// $router->add(new Route("admin_comment_confirm_delete", "/admin/confirm-delete-comment/:post/:id", ["post" => "\d+", "id" => "\d+"], "Controller\AdminController", "confirmDeleteComment", true));
// $router->add(new Route("admin_comment_delete", "/admin/delete-comment/:post/:id", ["post" => "\d+", "id" => "\d+"], "Controller\AdminController", "deleteComment", true));


$route = $router->find($request);

$response = $route->call($request, $router);
$response->send();