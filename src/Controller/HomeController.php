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
        // Get Database, Manager and find all Post
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $posts = $manager->findAll(0,8, "publicationDate", "DESC","", null, null, null);

        // View
        return $this->render("home.html.twig", ["posts" => $posts]);
    }

    /**
    * @return \App\Response\Response
    */
    public function sendMail()
    {
        // get $_POST
        $post = $this->getRequest()->getPost();

        // Contact Form
        if (!empty($post['name'])    &&
            !empty($post['email'])   &&
            !empty($post['message'])) 
        {
            $name = $post['name'];
            $email= $post['email'];
            $message = $post['message'];

            // Create the email and send the message
            $to = 'julienlombard.Fr@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
            $email_subject = "Formulaire de contact du site web:  $name";
            $email_body = "Vous avez reçu un nouveau message à partir du formulaire de contact de votre site Web.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nMessage:\n$message";
            $headers = "De: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
            $headers .= "Répondre à: $email";	
            mail($to,$email_subject,$email_body,$headers);
        }

        // Redirect Route
        return $this->redirect("home");
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showPost($id)
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // Get Database
        $database = $this->getDatabase();
        // Get Post Manager and find Post
        $postManager = $database->getManager(Post::class);
    	$post = $postManager->find($id);

        // Get Comments Manager and pagination
        $commentManager = $database->getManager(Comment::class);      
        $comments = $commentManager->getPagination($page, 0, 8, "publicationDate", "ASC", "postId", $id, "validate", "1", null, null);

        // View
        return $this->render("homePostShow.html.twig", [
            "id" => $id, 
            "post" => $post, 
            "comments" => $comments, 
            "page" => $this->getRequest()->getGet()['page'] ?? 1, 
            "pageCount" => ceil($commentManager->countAllComment("validate",1)/8)]);
    }

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