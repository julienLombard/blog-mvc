<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\Post;
use Model\Comment;

/**
 * Class PostController
 * @package Controller
 */
class PostController extends Controller
{
    /**
    * @return \App\Response\Response
    */
    public function showPost($id, $page = 1)
    {
        // Get $_REQUEST for page's number
        $request = $this->getRequest();
        $getPage = $request->getGet();
        $page = $getPage['page'];

        // Database
        $database = new Database("localhost","dev_blog", "root","");
        // Post SQL request
    	$postManager = $database->getManager(Post::class);
    	$post = $postManager->find($id);

        // Comments SQL request
        $commentManager = $database->getManager(Comment::class);      
        $comments = $commentManager->getPagination($page, 0, 8, "publicationDate", "ASC", "postID", $id);

        // Pagination
        $rows = $commentManager->findAll(0, 1000, "publicationDate", "ASC", "postID", $id);
        $pageCount = ceil(count($rows)/4);

        // View
        return $this->render("post.html.twig", ["post" => $post, "comments" => $comments, "page" => $page, "pageCount" => $pageCount]);
    }
}