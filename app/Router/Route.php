<?php
namespace App\Router;

use App\Request;
use App\Controller;
use App\Response\ResponseInterface;

/**
* Class Route
* @package App
*/
class Route
{
	/**
	* @var string
	*/
	private $name;
	/**
	* @var string
	*/
	private $path;
	/**
	* @var array
	*/
	private $parameters;
	/**
	* @var string
	*/
	private $controller;
	/**
	* @var string
	*/
	private $action;
	/**
	* @var boolean
	*/
	private $security;
	/**
	* @var array|string|mixed
	*/
	private $args;
	/**
	* @return string
	*/
	public function getName()
	{
	    return $this->name;
	}
	/**
	* @return string
	*/
	public function getPath()
	{
	    return $this->path;
	}
	/**
	* @return array
	*/
	public function getParameters()
	{
	    return $this->parameters;
	}
	/**
	* @return string
	*/
	public function getController()
	{
	    return $this->controller;
	}
	/**
	* @return string
	*/
	public function getAction()
	{
	    return $this->action;
	}
	/**
	* @return boolean
	*/
	public function getSecurity()
	{
	    return $this->security;
	}
	/**
	* Route constructor.
	* @param string $path
	* @param array $parameters
	* @param string $controller
	* @param string $action
	* @param string $security
	*/
	public function __construct($name, $path, array $parameters, $controller, $action, $security)
	{
		$this->name = $name;
		$this->path = $path;
		$this->parameters = $parameters;
		$this->controller = $controller;
		$this->action = $action;
		$this->security = $security;
		$this->args = [];
	}
	/**
	* @param $requestUri
	* @return boolean
	*/
	public function match($requestUri)
	{
		// new path with regex that replace the parameters
		$pattern = preg_replace_callback("/:(\w+)/", array($this, "checkParameters"), $this->path);		
		// escapes "/" for regex checking
		$pattern = preg_replace("~/~", "\/", $pattern);

		// if request does not match with regex, return False
		if(!preg_match("/^$pattern$/i", $requestUri, $matches))
		{
			return false;
		}

		// Otherwise fills an array of arguments with the values of each parameter of the route
		$this->args = array_combine(array_keys($this->parameters), array_slice($matches, 1));
		return true;

	}
    /**
    * @param $match
    * @return string
    */
	private function checkParameters($match)
	{
		if (isset($this->parameters[$match[1]])) 
		{
			return sprintf("(%s)", $this->parameters[$match[1]]);
		} 
		else 
		{	
			// else return a regex by default
			return '([^/]+)';
		}
	}
	 
    /**
    * @param Request $request
    * @param Router $router
	* @return ResponseInterface
	*/
	public function call(Request $request, Router $router)
	{
		
		// Controller instantiation
		$controller = $this->controller;
		$controller = new $controller($request, $router);

		// Call the [$foo->, $bar ]() function with arguments 
		return call_user_func_array([$controller, $this->action], $this->args);
	}

	/**
	* @param array $args
	* @return string $url
	*/
	public function generateUrl($args)
	{
		// replaces each parameter of the path with args, then deleting ":"
		$url = str_replace(array_keys($args), $args, $this->path);
		$url = str_replace(":", "", $url);
		
		return $url;
	}

	/**
	* @param Request $request
	* @return boolean
	*/
	public function isGranted(Request $request) 
	{
		if ($request->getSession()['administrator'] == true) {
			return true;
		} else {
			return false;
		}
    }
}