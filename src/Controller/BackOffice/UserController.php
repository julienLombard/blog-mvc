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
        // Error Message Var
        $alert = $alert ?? 0;
        
        // get $_SESSION
        $session = $this->getRequest()->getSession();

        // get $_POST
        $post = $this->getRequest()->getPost();
        // get Database and UserManager
        $database = $this->getDatabase();
        $userManager = $database->getManager(User::class);

        // Data treatment of Connection Form
        if (isset($post['login'])) {
            $connection = $userManager->getConnection($post['login'],$post['password']);

            // Match login & password
            if (($post['login'] === $connection['login']) &&
                (md5($post['password']) === $connection['password'])){
                
                // Define session's login name
                $_SESSION['login'] = $session['login'] ?? $post['login'];

                // To Back office
                return $this->redirect("admin");
            } else {
                $alert = 1;
                // Back to connection page
                return $this->render("adminUserConnection.html.twig", ["alert" => $alert]);
            }
        } elseif (isset($session['login'])) // elseif User is already logged
       {
            // To Back office
            return $this->redirect("admin");
        } else {
            // Back to connection page
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
    */
    public function showBackOffice()
    {   
        // View
        return $this->render("adminHome.html.twig");

    }
}