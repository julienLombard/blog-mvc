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
	* Controller constructor.
	* @param Request $request
	* @param Router $router
	*/
	public function __construct(Request $request, Router $router)
	{
		$this->request = $request;
		$this->router = $router;
		$this->database = Database::getInstance($request);

		$loader = new \Twig_Loader_Filesystem('../src/View');
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
		$route = $this->router->getRoute($routeName);
		
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
		$view = $this->twig->load($filename);
		$content = $view->render($data);

		return new Response($content);
	}
	
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
}