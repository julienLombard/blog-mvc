<?php

namespace App;

use App\Router\Router;
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
	* Controller constructor.
	* @param Request $request
	* @param Router $router
	*/
	public function __construct(Request $request, Router $router)
	{
		$this->request = $request;
		$this->router = $router;
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
}