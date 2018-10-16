<?php

namespace Controller\BackOffice;

use App\Controller;
use App\ORM\Database;
// use Model\User;
use Model\Post;
use Model\Comment;

/**
 * Class CommentController
 * @package Controller
 */
class CommentController extends Controller
{

    /**
    * @return \App\Response\Response
    */
    public function commentsList()
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // Database
        $database = $this->getDatabase();
        // Posts SQL request
        $manager = $database->getManager(Post::class);
        $posts = $manager->getPagination($page, 0, 4, "publicationDate", "ASC", "", null);

        // View
        return $this->render("adminCommentsList.html.twig", [
            "posts" => $posts,
            "page" => $page, 
            "pageCount" => ceil($manager->countAllPost()/4)]);       
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showComments($id)
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // Database
        $database = $this->getDatabase();
        // find Post
        $postManager = $database->getManager(Post::class);
        $post = $postManager->find($id);

        // get Comment Manager and get pagination
        $commentManager = $database->getManager(Comment::class);      
        $comments = $commentManager->getPagination($page, 0, 8, "publicationDate", "ASC", "post_Id", $id, null, null);

        // View
        return $this->render("adminCommentsShow.html.twig", [
            "post" => $post,
            "comments" => $comments,
            "page" => $page,
            "pageCount" => ceil($commentManager->countByPost($id)/8)]);      
    }

    /**
    * @param $post
    * @param $id
    * @return \App\Response\Response
    */
    public function validateComment($post, $id) 
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;
        
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);
        
        // Set and update Comment to Validate
        $comment->setValidate(1);
        $manager->update($comment);
        
        // Redirect Route
        return $this->redirect("admin_comments_show", ["id" => $post]);       
    }

    /**
    * @param $post
    * @param $id
    * @return \App\Response\Response
    */
    public function showEditComment($post, $id)
    {
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);
        
        // View
        return $this->render("adminCommentEdit.html.twig", ["post" => $post, "comment" => $comment]);       
    }

    /**
    * @param $post
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function updateComment($post, $id)
    {
        // get $_POST data
        $request = $this->getRequest();
        $formPost = $request->getPost();
        
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);
        
        // Set and update Comment
        $comment->setAuthor($formPost['author']);
        $comment->setContent($formPost['content']);
        $comment->setModificationDate(new \DateTime());
        $manager->update($comment);
        
        // Redirect route
        return $this->redirect("admin_comments_show", ["id" => $post]);      
    }

    /**
    * @param $post
    * @param $id
    * @return \App\Response\Response
    */
    public function confirmDeleteComment($post, $id)
    {
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);
        
        // View
        return $this->render("adminCommentConfirmDelete.html.twig", ["post" => $post, "comment" => $comment]);        
    }

    /**
    * @param $post
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function deleteComment($post, $id)
    {
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);

        // Delete Comment
        $manager->delete($comment);
        
        // Redirect route
        return $this->redirect("admin_comments_show", ["id" => $post]);      
    }

    /**
    * @param $post
    * @param $id
    * @return \App\Response\Response
    */
    public function moderateComment($post, $id) 
    {
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);
        
        // Set and update Comment to Report = false
        $comment->setReported(0);
        $manager->update($comment);
        
        // Redirect route
        return $this->redirect("admin_comments_show", ["id" => $post]);       
    }

    /**
    * @return \App\Response\Response
    */
    public function showInvalidated()
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // Database
        $database = $this->getDatabase();
        // Comments SQL request
        $manager = $database->getManager(Comment::class);
        $comments = $manager->getPagination($page, 0, 8, "publicationDate", "DESC", "validate", "0", null, null);

        // View
        return $this->render("adminCommentsShowInvalidated.html.twig", [
            "comments" => $comments,
            "page" => $page, 
            "pageCount" => ceil($manager->countAllComment("validate",0)/8)]);      
    }

        /**
    * @return \App\Response\Response
    */
    public function showReported()
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // Database
        $database = $this->getDatabase();
        // Comments SQL request
        $manager = $database->getManager(Comment::class);
        $comments = $manager->getPagination($page, 0, 8, "publicationDate", "DESC", "reported", "1", null, null);

        return $this->render("adminCommentsShowReported.html.twig", [
            "comments" => $comments,
            "page" => $page, 
            "pageCount" => ceil($manager->countAllComment("reported",1)/8)]);      
    }
}