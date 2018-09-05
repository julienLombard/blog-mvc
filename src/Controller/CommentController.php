<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\Comment;

/**
 * Class CommentController
 * @package Controller
 */
class CommentController extends Controller
{
    public function createComment($id) {

        $request = $this->getRequest();
        $formPost = $request->getPost();

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);

        $comment = new Comment();
        $comment->setPostId($formPost['postId']);
        $comment->setAuthor($formPost['author']);
        $comment->setContent($formPost['content']);
        $comment->setPublicationDate(new \DateTime());
        $manager->insert($comment);

        header("Location: http://localhost:8080/post/$id#post");
    }
}