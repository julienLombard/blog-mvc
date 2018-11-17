<?php

namespace Controller\FrontOffice;

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
    public function index()
    {
        // get $_SESSION
        $session = $this->getRequest()->getSession();

        // Get Database, Manager and find all Post
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $posts = $manager->findAll(0,8, "publicationDate", "DESC","", null, null, null);

        // View
        return $this->render("home.html.twig", ["posts" => $posts, "session" => $session]);
    }

    /**
    * @return \App\Response\Response
    */
    public function postsList()
    {       
        // get $_SESSION
        $session = $this->getRequest()->getSession();

        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // get Database and PostManager
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        
        // Pagination
        $posts = $manager->getPagination($page, 0, 4, "publicationDate", "DESC", "", null);
        
        // View
        return $this->render("homePostsList.html.twig", [
            "posts" => $posts, 
            "page" => $page, 
            "pageCount" => ceil($manager->countAllPost()/4),
            "session" => $session]);    

    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showPost($id)
    {
        // get $_SESSION
        $session = $this->getRequest()->getSession();

        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // Get Database
        $database = $this->getDatabase();
        // Get Post Manager and find Post
        $postManager = $database->getManager(Post::class);
    	$post = $postManager->find($id);

        // Get Comments Manager and pagination
        $commentManager = $database->getManager(Comment::class);      
        $comments = $commentManager->getPagination($page, 0, 8, "publicationDate", "ASC", "postId", $id, "validate", "1");

        // View
        return $this->render("homePostShow.html.twig", [
            "id" => $id, 
            "post" => $post, 
            "comments" => $comments, 
            "page" => $this->getRequest()->getGet()['page'] ?? 1, 
            "pageCount" => ceil($commentManager->countValidByPost($id)/8),
            "session" => $session]);
    }

    /**
    * @return \App\Response\Response
    */
    public function sendMail()
    {
        // get $_SESSION
        $session = $this->getRequest()->getSession();

        // get $_POST
        $post = $this->getRequest()->getPost();
        $alert = 0;

        // Contact Form
        if (!empty($post['name'])    &&
            !empty($post['email'])   &&
            !empty($post['message'])) 
        {
            $name = htmlspecialchars($post['name']);
            $email= htmlspecialchars($post['email']);
            $message = htmlspecialchars($post['message']);
            $alert = 1;

            // Create the email and send the message
            $to = 'julienlombard.Fr@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
            $email_subject = "Formulaire de contact du site web:  $name";
            $email_body = "Vous avez reçu un nouveau message à partir du formulaire de contact de votre site Web.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nMessage:\n$message";
            $headers = "De: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
            $headers .= "Répondre à: $email";	
            mail($to,$email_subject,$email_body,$headers);

        } elseif (empty($post['name'])    ||
                empty($post['email'])   ||
                empty($post['message'])) 
        {
            $alert = 2;
        }

        // Get Database, Manager and find all Post
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $posts = $manager->findAll(0,8, "publicationDate", "DESC","", null, null, null);

        // Redirect Route
        return $this->render("home.html.twig", [
            "posts" => $posts,
            "alert" => $alert,
            "session" => $session]);
    }
}