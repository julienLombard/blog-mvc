<?php

namespace App;

use App\ORM\Database;
use App\Router\Router;
use App\Response\Response;
use App\Response\RedirectResponse;

/**
* Class Controller
* @package App
*/
class Controller
{
	/**
	* @var Request
	*/
	private $request;
	/**
	* @var Router
	*/
	private $router;
	/**
	* @var \Twig_Environment
	*/
	private $twig;
	/**
	* @var Database
	*/
	private $database;

	/**
	* @return Database
	*/
	protected function getDatabase()
	{
		return $this->database;
	}

	/**
	* @return Request
	*/
	protected function getRequest()
	{
		return $this->request;
	}

	/**
	* Controller constructor.
	* @param Request $request
	* @param Router $router
	*/
	public function __construct(Request $request, Router $router)
	{
		$this->request = $request;
		$this->router = $router;
		$this->database = Database::getInstance($request);

		// Twig Loader instanciation
		$loader = new \Twig_Loader_Filesystem('../src/View');
		// Twig Environnement instanciation
		$this->twig = new \Twig_Environment($loader, array('cache' => false,));
		$this->twig->addExtension(new \Twig_Extensions_Extension_Text());

	}

	/**
	* @param string $routeName
	* @param array $args
	* @return RedirectResponse
	*/
	protected function redirect($routeName, $args = [])
	{	
		// get Route by name
		$route = $this->router->getRoute($routeName);		
		// generate Url with Route's arguments
		$url = $route->generateUrl($args);

		return new RedirectResponse($url);
	}

	/**
	* @param string $filename
	* @param array $data
	* @return Response
	*/
	protected function render($filename, $data = [])
	{	
		// loadig View
		$view = $this->twig->load($filename);
		// gets the content of the view by passing $data
		$content = $view->render($data);

		return new Response($content);
	}

}