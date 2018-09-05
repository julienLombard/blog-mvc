<?php

namespace Controller;

use App\Controller;
use App\ORM\Database;
use Model\Post;
use Model\Comment;

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
        $posts = $manager->findAll(0,8, "publicationDate", "DESC", "", null);

        return $this->render("adminHome.html.twig", ["post" => $post, "posts" => $posts]);
    }

    /**
    * @param $page = 1
    * @return \App\Response\Response
    */
    public function postsList($page = 1)
    {
        $request = $this->getRequest();
        $getPage = $request->getGet();
        $page = $getPage['page'];

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Post::class);

        $posts = $manager->getPagination($page, 0, 4, "publicationDate", "DESC", "", null);

        $rows = $manager->findAll(0, 1000, "publicationDate", "DESC", "", null);
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
        // to create form
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

    /**
    * @param $page = 1
    * @return \App\Response\Response
    */
    public function commentsList($page = 1)
    {
        // Get $_REQUEST for page's number
        $request = $this->getRequest();
        $getPage = $request->getGet();
        $page = $getPage['page'];

        // Database
        $database = new Database("localhost","dev_blog", "root","");
        // Posts SQL request
        $manager = $database->getManager(Post::class);
        $posts = $manager->getPagination($page, 0, 4, "publicationDate", "ASC", "", null);

        // Pagination
        $rows = $manager->findAll(0, 1000, "publicationDate", "ASC", "", null);
        $pageCount = ceil(count($rows)/4);

        // View
        return $this->render("adminCommentsList.html.twig", ["posts" => $posts, "page" => $page, "pageCount" => $pageCount]);
    }

    /**
    * @param $id
    * @param $page =1
    * @return \App\Response\Response
    */
    public function showComments($id, $page = 1)
    {
        // Get $_REQUEST for page's number
        $request = $this->getRequest();
        $getPage = $request->getGet();
        $page = $getPage['page'];

        // Database
        $database = new Database("localhost","dev_blog", "root","");
        // Post SQL request
    	$postManager = $database->getManager(Post::class);
    	$post = $postManager->find($id);

        // Comments SQL request
        $commentManager = $database->getManager(Comment::class);      
        $comments = $commentManager->getPagination($page, 0, 8, "publicationDate", "ASC", "postID", $id);

        // Pagination
        $rows = $commentManager->findAll(0, 1000, "publicationDate", "ASC", "postID", $id);
        $pageCount = ceil(count($rows)/4);

        // View
        return $this->render("adminShowComments.html.twig", ["post" => $post, "comments" => $comments, "page" => $page, "pageCount" => $pageCount]);
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function validateComment($id) 
    {
        // Get $_REQUEST
        // $request = $this->getRequest();
        // // Post's number     
        // $getPost = $request->getGet();
        // $post = $getPost['post'];
        // // Page's number
        // $getPage = $request->getGet();
        // $page = $getPage['page'];

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);

        $comment = $manager->find($id);

        $comment->setValidate(1);
        $manager->update($comment);

        // header("Location: http://localhost:8080/admin/comments-post/$post?page=$page#comment$id");
        // header("Location: http://localhost:8080/admin/comments-post/$post?page=1");
        header("Location: http://localhost:8080/admin/comments?page=1");
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function showEditComment($id)
    {

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);

        return $this->render("adminEditComment.html.twig", ["comment" => $comment]);
    }

    /**
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function updateComment($id)
    {
        $request = $this->getRequest();
        $formPost = $request->getPost();

        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);

        $comment->setAuthor($formPost['author']);
        $comment->setContent($formPost['content']);
        $comment->setModificationDate(new \DateTime());
        $manager->update($comment);

        header("Location: http://localhost:8080/admin/comments?page=1");
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function confirmDeleteComment($id)
    {
        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);

        return $this->render("adminConfirmDeleteComment.html.twig", ["comment" => $comment]);
    }

    /**
    * @param $id
    * @return \App\Response\RedirectResponse
    */
    public function deleteComment($id)
    {
        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);
        $comment = $manager->find($id);
        $manager->delete($comment);

        header("Location: http://localhost:8080/admin/comments?page=1");
    }

    /**
    * @param $id
    * @return \App\Response\Response
    */
    public function moderateComment($id) 
    {
        $database = new Database("localhost","dev_blog", "root","");
        $manager = $database->getManager(Comment::class);

        $comment = $manager->find($id);

        $comment->setReported(0);
        $manager->update($comment);

        header("Location: http://localhost:8080/admin/comments?page=1");
    }
}