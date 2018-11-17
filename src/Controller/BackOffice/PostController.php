<?php

namespace Controller\BackOffice;

use App\Controller;
use App\ORM\Database;
use Model\User;
use Model\Post;

/**
 * Class PostController
 * @package Controller
 */
class PostController extends Controller
{

    /**
    * @return \App\Response\Response
    */
    public function postsList()
    {          
        // get $_GET for page's number
        $page = $this->getRequest()->getGet()['page'] ?? 1;

        // get Database and PostManager
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        
        // Pagination
        $posts = $manager->getPagination($page, 0, 4, "publicationDate", "DESC", "", null);
        
        // View
        return $this->render("adminPostsList.html.twig", [
            "posts" => $posts, 
            "page" => $page, 
            "pageCount" => ceil($manager->countAllPost()/4)]);    

    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showAdminPost($id)
    {
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);

        return $this->render("adminPostShow.html.twig", ["post" => $post]);
        
    }

    /**
    * @return \App\Response\Response
    */
    public function createPostForm() 
    {
        // View: to create form
        return $this->render("adminPostCreateForm.html.twig");
        
    }

    /**
    * @return \App\Response\RedirectResponse
    */
    public function createPost() 
    {
        // get $_POST
        $request = $this->getRequest();
        $formPost = $request->getPost();
        // get Database and Manager
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        
        // set Post and insert it in database
        $post = new Post();
        $post->setTitle($formPost['title']);
        $post->setAuthor($formPost['author']);
        $post->setSynopsis($formPost['synopsis']);
        $post->setContent($formPost['content']);
        $post->setPublicationDate(new \DateTime());
        $manager->insert($post);
        
        // Redirect route
        return $this->redirect("admin_posts_list");
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showEditPost($id)
    {
        // Get Database, Manager and find Post
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);
        
        // View
        return $this->render("adminPostEdit.html.twig", ["post" => $post]);       
    }

    /**
     * @param $id
     * @return \App\Response\Response
     */
    public function updatePost($id)
    {
        // get $_POST
        $request = $this->getRequest();
        $formPost = $request->getPost();
        
        // Get Database, Manager and find Post
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);
        
        // Set and update Post
        $post->setTitle($formPost['title']);
        $post->setAuthor($formPost['author']);
        $post->setSynopsis($formPost['synopsis']);
        $post->setContent($formPost['content']);
        $post->setModificationDate(new \DateTime());
        $manager->update($post);
        
        // View
        return $this->render("adminPostShow.html.twig", ["post" => $post]);
        
    }

    /**
     * @param $id
     * @return \App\Response\Response
     */
    public function confirmDeletePost($id)
    {

        // Get Database, Manager and find Post
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);
        
        // View
        return $this->render("adminPostConfirmDelete.html.twig", ["post" => $post]);
        
    }

    /**
     * @param $id
     * @return \App\Response\RedirectResponse
     */
    public function deletePost($id)
    {
        // Get Database, Manager and find Post
        $database = $this->getDatabase();
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);

        // Delete Post
        $manager->delete($post);
        
        // Redirect route
        return $this->redirect("admin_posts_list");
        
    }
}