<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\Post;

/**
 * Class AdminController
 * @package Controller
 */
class AdminController extends Controller
{
    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showData($id = null)
    {
    	$database = new Database("localhost","dev_blog", "root","");
    	$manager = $database->getManager(Post::class);

    	$post = $manager->find($id);
        $posts = $manager->findAll(0,8, "publicationDate", "DESC");

        return $this->render("adminHome.html.twig", ["post" => $post, "posts" => $posts]);
    }

    /**
    * @return \App\Response\Response
    */
    public function postsList($page = 1)
    {
        $request = $this->getRequest();
        $getPage = $request->getGet();
        $page = $getPage['page'];

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);

        $posts = $manager->getPagination($page, 0, 4, "publicationDate", "DESC");

        $rows = $manager->findAll(0, 1000, "publicationDate", "DESC");
        $pageCount = ceil(count($rows)/4);
        // echo "<pre>";
        // print_r($pageCount);
        // exit;

        return $this->render("adminPosts.html.twig", ["posts" => $posts, "page" => $page, "pageCount" => $pageCount]);
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showAdminPost($id)
    {
        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);

        return $this->render("adminPost.html.twig", ["post" => $post]);
    }

    /**
    * @return \App\Response\Response
    */
    public function createPostForm() 
    {
        return $this->render("adminCreatePostForm.html.twig");
    }

    /**
    * @return \App\Response\Response
    */
    public function createPost() 
    {
        $request = $this->getRequest();
        $formPost = $request->getPost();

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);

        $post = new Post();
        $post->setTitle($formPost['title']);
        $post->setContent($formPost['content']);
        $post->setPublicationDate(new \DateTime());
        $manager->insert($post);

        header("Location: http://localhost:8080/admin/posts");
    }


    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showEditPost($id)
    {

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);

        return $this->render("adminEditPost.html.twig", ["post" => $post]);
    }

    /**
     * @param $id
     * @return \App\Response\RedirectResponse
     */
    public function updatePost($id)
    {
        $request = $this->getRequest();
        $formPost = $request->getPost();

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);

        $post->setTitle($formPost['title']);
        $post->setContent($formPost['content']);
        $post->setModificationDate(new \DateTime());
        $manager->update($post);

        return $this->render("adminPost.html.twig", ["post" => $post]);

    }

    /**
     * @param $id
     * @return \App\Response\RedirectResponse
     */
    public function confirmDeletePost($id)
    {
        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);

        return $this->render("adminConfirmDeletePost.html.twig", ["post" => $post]);
    }

    /**
     * @param $id
     * @return \App\Response\RedirectResponse
     */
    public function deletePost($id)
    {
        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);
        $post = $manager->find($id);
        $manager->delete($post);

        header("Location: http://localhost:8080/admin/posts");
    }
}