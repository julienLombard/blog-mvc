<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\Post;

/**
 * Class PostController
 * @package Controller
 */
class PostController extends Controller
{
    /**
    * @return \App\Response\Response
    */
    public function showPost($id)
    {
    	$database = new Database("localhost","dev_blog", "root","");
    	$manager = $database->getManager(Post::class);
    	$post = $manager->find($id);

        return $this->render("post.html.twig", ["post" => $post]);
    }
}