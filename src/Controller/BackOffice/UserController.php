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
        if (isset($post['submit'])) {
            $connection = $userManager->getConnection($post['login'],$post['password']);

            // Match login & password
            if ((htmlspecialchars($post['login']) === $connection['login']) &&
                (md5(htmlspecialchars($post['password'])) === $connection['password'])){
                
                // Define session's variables
                $_SESSION['id'] = $connection['id'];
                $_SESSION['login'] = $connection['login'];
                $_SESSION['validate'] = $connection['validate'];
                $_SESSION['administrator'] = $connection['administrator'];

                if ($_SESSION['administrator'] == true) {

                    // To Backoffice
                    return $this->redirect("admin");
                } elseif ($_SESSION['validate'] == false) {
                    
                    // To Home with destroyed session
                    return $this->logout();
                } else {
                    
                    // To Home
                    return $this->redirect("home");
                }

            } else {
                $alert = 1;
                // Back to connection page
                return $this->render("adminUserConnection.html.twig", ["alert" => $alert]);
            }

            // elseif Administrator is already logged
        } elseif (!empty($session['administrator'])) {
            
            // To Back office
            return $this->redirect("admin");
        } elseif (empty($session['administrator']) &&
                    !empty($session['login'])) {
            
            // To Home
            return $this->redirect("home");
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

    /**
    * @return \App\Response\Response
    */
    public function showMembers()
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // Database
        $database = $this->getDatabase();
        // Users SQL request
        $manager = $database->getManager(User::class);
        $users = $manager->getPagination($page, 0, 4, "registerDate", "ASC", "", null);

        // View
        return $this->render("adminUsersList.html.twig", [
            "users" => $users,
            "page" => $page, 
            "pageCount" => ceil($manager->countAllUsers()/4)]);       
    }

    /**
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function validateUser($id) 
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;
        
        // Get Database, Manager and find User
        $database = $this->getDatabase();
        $manager = $database->getManager(User::class);
        $user = $manager->find($id);
        
        // Set and update User to Validate
        $user->setValidate(1);
        $manager->update($user);
        
        // Redirect Route
        return $this->redirect("admin_members");       
    }

    /**
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function upgradeUser($id) 
    {
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;
        
        // Get Database, Manager and find User
        $database = $this->getDatabase();
        $manager = $database->getManager(User::class);
        $user = $manager->find($id);
        
        // Set and update User to Administrator
        $user->setAdministrator(1);
        $manager->update($user);
        
        // Redirect Route
        return $this->redirect("admin_members");       
    }

    /**
    * @return \App\Response\Response
    */
    public function register() 
    {
        // Validation Message Var
        $alert = $alert ?? 0;

        // get $_POST
        $formPost = $this->getRequest()->getPost();

        // get Database and UserManager
        $database = $this->getDatabase();
        $userManager = $database->getManager(User::class);

        // Register Form
        if (!empty($formPost['login'])    &&
        !empty($formPost['password'])) {

            // set User and insert it in database
            $user = new User();
            $user->setLogin(htmlspecialchars($formPost['login']));
            $user->setPassword(md5(htmlspecialchars($formPost['password'])));
            $user->setRegisterDate(new \DateTime());
            $userManager->insert($user);
            
            // Message
            $alert = 1;

            // View
            return $this->render("adminUserRegister.html.twig", ["alert" => $alert]);

        } elseif ((isset($formPost['submit'])) && 
        (empty($formPost['login'])    ||
        empty($formPost['password']))) {

            // Message
            $alert = 2;
        }
        
        // View
        return $this->render("adminUserRegister.html.twig", ["alert" => $alert]);
    }
}