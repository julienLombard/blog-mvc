<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\Post;
use Model\Comment;

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
        $posts = $manager->findAll(0,8, "publicationDate", "DESC","", null);

        return $this->render("home.html.twig", ["posts" => $posts]);
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function reportedComment($id) 
    {
        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);

        $comment = $manager->find($id);

        $comment->setReported(1);
        $manager->update($comment);

        header("Location: http://localhost:8080/#portfolio");
    }
}