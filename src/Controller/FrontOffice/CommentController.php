<?php

namespace Controller\FrontOffice;

use App\Controller;
use App\ORM\Database;
// use Model\Post;
use Model\Comment;

/**
 * Class CommentController
 * @package Controller
 */
class CommentController extends Controller
{

    /**
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function createComment($id) 
    {
        // Get $_REQUEST for page's number
        $request = $this->getRequest();
        $formPost = $request->getPost();
        $page = $formPost['pageNb'] ?? 1;

        // Get Database and Manager
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);

        // Set new Comment and insert it in database
        $comment = new Comment();
        $comment->setPostId($formPost['postId']);
        $comment->setAuthor($formPost['author']);
        $comment->setContent($formPost['content']);
        $comment->setPublicationDate(new \DateTime());
        $manager->insert($comment);
        
        // View
        return $this->redirect("home_post_show", ["id" => $id]);
    }

    /**
    * @param $post
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function reportedComment($post, $id) 
    {
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);

        // Set and update Comment to reported
        $comment->setReported(1);
        $manager->update($comment);

        // View
        return $this->redirect("home_post_show", ["id" => $post]);
    }
}