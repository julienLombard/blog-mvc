<?php

namespace Controller\BackOffice;

use App\Controller;
use App\ORM\Database;
use Model\User;

/**
 * Class UserController
 * @package Controller
 */
class UserController extends Controller
{

    /**
    * @return \App\Response\Response
    * @return \App\Response\RedirectResponse
    */
    public function connection() 
    {
        // get $_SESSION
        $session = $this->getRequest()->getSession();

        if (isset($session['login'])) 
        {   
            // Redirect Route
            return $this->redirect("admin");
        } else {

            // View
            return $this->render("adminUserConnection.html.twig");
        }
    }

    /**
    * @return \App\Response\RedirectResponse
    */
    public function logout() 
    {
        session_destroy();
        // Redirect Route
        return $this->redirect("home");       
    }

    /**
    * @return \App\Response\Response
    * @return \App\Response\RedirectResponse
    */
    public function showBackOffice()
    {   
        // get $_SESSION
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
                (md5($post['password']) === $connection['password'])){
                
                // Define session's login name
                $_SESSION['login'] = $session['login'] ?? $post['login'];

                // View
                return $this->render("adminHome.html.twig");
            } else {
                // Redirect Route
                return $this->redirect("admin_user_connection");
            }
        } elseif (isset($session['login'])) // elseif User is already logged
        {
            // View
            return $this->render("adminHome.html.twig");
        } else {
            // Redirect Route
            return $this->redirect("admin_user_connection");
        }
    }
}