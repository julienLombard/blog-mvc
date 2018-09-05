<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\Post;

/**
 * Class DefaultController
 * @package Controller
 */
class HomeController extends Controller
{
    /**
    * @return \App\Response\Response
    */
    public function index()
    {
    	$database = new Database("localhost","dev_blog", "root","");
    	$manager = $database->getManager(Post::class);
    	$posts = $manager->findAll(0,8, "publicationDate", "DESC");

        return $this->render("home.html.twig", ["posts" => $posts]);
    }
}