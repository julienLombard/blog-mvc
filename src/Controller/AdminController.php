<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\User;
use Model\Post;
use Model\Comment;

/**
 * Class AdminController
 * @package Controller
 */
class AdminController extends Controller
{

    /**
    * @return \App\Response\Response
    */
    public function connection() 
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        if (isset($session['login'])) 
        {   
            // Redirect Route
            return $this->redirect("admin");
        } else {
            // View
            return $this->render("adminConnection.html.twig");
        }
    }

    public function logout() 
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            session_destroy();
            // Redirect Route
            return $this->redirect("home");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @return \App\Response\Response
    */
    public function showData()
    {   
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();
        
        // get $_POST
        $post = $this->getRequest()->getPost();
        // get Database ad UserManager
        $database = $this->getDatabase();
        $userManager = $database->getManager(User::class);

        // Data Form treatment
        if (isset($post['login'])) {
            $connection = $userManager->getConnection($post['login'],$post['password']);
            // Match login & password
            if (($post['login'] === $connection['login']) &&
                ($post['password'] === $connection['password'])){
                $_SESSION['login'] = $session['login'] ?? $post['login'];

                // View
                return $this->render("adminHome.html.twig");
            } else {
                // Redirect Route
                return $this->redirect("admin_connection");
            }
        } elseif (isset($session['login'])) // elseif User is already logged
        {
            // View
            return $this->render("adminHome.html.twig");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $page = 1
    * @return \App\Response\Response
    */
    public function postsList()
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {
            
            // get $_GET for page's number
            $page = $this->getRequest()->getGet()['page'] ?? 1;

            // get Database and PostManager
            $database = $this->getDatabase();
            $manager = $database->getManager(Post::class);
            
            // Pagination
            $posts = $manager->getPagination($page, 0, 4, "publicationDate", "DESC", "", null);
            
            // View
            return $this->render("adminPosts.html.twig", [
                "posts" => $posts, 
                "page" => $page, 
                "pageCount" => ceil($manager->countAllPost()/4)]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }

    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showAdminPost($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {
            $database = $this->getDatabase();
            $manager = $database->getManager(Post::class);
            $post = $manager->find($id);
    
            return $this->render("adminPost.html.twig", ["post" => $post]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @return \App\Response\Response
    */
    public function createPostForm() 
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // View: to create form
            return $this->render("adminCreatePostForm.html.twig");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @return \App\Response\Response
    */
    public function createPost() 
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {
            // get $_POST
            $request = $this->getRequest();
            $formPost = $request->getPost();
            // get Database and Manager
            $database = $this->getDatabase();
            $manager = $database->getManager(Post::class);
            
            // set Post and insert it in database
            $post = new Post();
            $post->setTitle($formPost['title']);
            $post->setContent($formPost['content']);
            $post->setPublicationDate(new \DateTime());
            $manager->insert($post);
            
            // Redirect route
            return $this->redirect("admin_posts");
            // header("Location: http://localhost:8080/admin/posts");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }

    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showEditPost($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // Get Database, Manager and find Post
            $database = $this->getDatabase();
            $manager = $database->getManager(Post::class);
            $post = $manager->find($id);
            
            // View
            return $this->render("adminEditPost.html.twig", ["post" => $post]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }

    }

    /**
     * @param $id
     * @return \App\Response\RedirectResponse
     */
    public function updatePost($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {
            // get $_POST
            $request = $this->getRequest();
            $formPost = $request->getPost();
            
            // Get Database, Manager and find Post
            $database = $this->getDatabase();
            $manager = $database->getManager(Post::class);
            $post = $manager->find($id);
            
            // Set and update Post
            $post->setTitle($formPost['title']);
            $post->setContent($formPost['content']);
            $post->setModificationDate(new \DateTime());
            $manager->update($post);
            
            // View
            return $this->render("adminPost.html.twig", ["post" => $post]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
     * @param $id
     * @return \App\Response\RedirectResponse
     */
    public function confirmDeletePost($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // Get Database, Manager and find Post
            $database = $this->getDatabase();
            $manager = $database->getManager(Post::class);
            $post = $manager->find($id);
            
            // View
            return $this->render("adminConfirmDeletePost.html.twig", ["post" => $post]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
     * @param $id
     * @return \App\Response\RedirectResponse
     */
    public function deletePost($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // Get Database, Manager and find Post
            $database = $this->getDatabase();
            $manager = $database->getManager(Post::class);
            $post = $manager->find($id);

            // Delete Post
            $manager->delete($post);
            
            // Redirect route
            return $this->redirect("admin_posts");
            // header("Location: http://localhost:8080/admin/posts");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $page = 1
    * @return \App\Response\Response
    */
    public function commentsList()
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

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
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $id
    * @param $page =1
    * @return \App\Response\Response
    */
    public function showComments($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // get $_GET for page's number
            $page = $this->getRequest()->getGet()['page'] ?? 1;

            // Database
            $database = $this->getDatabase();
            // find Post
            $postManager = $database->getManager(Post::class);
            $post = $postManager->find($id);

            // get Comment Manager and get pagination
            $commentManager = $database->getManager(Comment::class);      
            $comments = $commentManager->getPagination($page, 0, 8, "publicationDate", "ASC", "postID", $id);

            // View
            return $this->render("adminShowComments.html.twig", [
                "post" => $post,
                "comments" => $comments,
                "page" => $page,
                "pageCount" => ceil($commentManager->countByPost($id)/4)]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function validateComment($id) 
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

        // Get $_REQUEST
        // $request = $this->getRequest();
        // // Post's number     
        // $getPost = $request->getGet();
        // $post = $getPost['post'];
        // // Page's number
        // $getPage = $request->getGet();
        // $page = $getPage['page'];
        
        // Get Database, Manager and find Comment
        $database = $this->getDatabase();
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);
        
        // Set and update Comment to Validate
        $comment->setValidate(1);
        $manager->update($comment);
        
        // Redirect Route
        // header("Location: http://localhost:8080/admin/comments-post/$post?page=$page#comment$id");
        // header("Location: http://localhost:8080/admin/comments-post/$post?page=1");
        // header("Location: http://localhost:8080/admin/comments?page=1");
        return $this->redirect("admin_comments_list");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showEditComment($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // Get Database, Manager and find Comment
            $database = $this->getDatabase();
            $manager = $database->getManager(Comment::class);
            $comment = $manager->find($id);
            
            // View
            return $this->render("adminEditComment.html.twig", ["comment" => $comment]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function updateComment($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

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
            return $this->redirect("admin_comments_list");
            // header("Location: http://localhost:8080/admin/comments?page=1");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function confirmDeleteComment($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // Get Database, Manager and find Comment
            $database = $this->getDatabase();
            $manager = $database->getManager(Comment::class);
            $comment = $manager->find($id);
            
            // View
            return $this->render("adminConfirmDeleteComment.html.twig", ["comment" => $comment]);
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function deleteComment($id)
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // Get Database, Manager and find Comment
            $database = $this->getDatabase();
            $manager = $database->getManager(Comment::class);
            $comment = $manager->find($id);

            // Delete Comment
            $manager->delete($comment);
            
            // Redirect route
            return $this->redirect("admin_comments_list");
            // header("Location: http://localhost:8080/admin/comments?page=1");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function moderateComment($id) 
    {
        // get $_SESSION
        session_start();
        $session = $this->getRequest()->getSession();

        // if User is already logged
        if (isset($session['login'])) {

            // Get Database, Manager and find Comment
            $database = $this->getDatabase();
            $manager = $database->getManager(Comment::class);
            $comment = $manager->find($id);
            
            // Set and update Comment to Report = false
            $comment->setReported(0);
            $manager->update($comment);
            
            // Redirect route
            return $this->redirect("admin_comments_list");
            // header("Location: http://localhost:8080/admin/comments?page=1");
        } else {
            // Redirect Route
            return $this->redirect("admin_connection");
        }
    }
}