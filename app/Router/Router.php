<?php
namespace App\Router;

use App\Request;
use App\Router\Route;

/**
* Class Router
* @package App
*/
class Router
{
	/**
	* @var array
	*/
	private $routes;
	/**
	* @var Request
	*/
	private $request;
    /**
     * Request constructor.
     * @param Request $request
     */
    public function __construct($request)
    {
    	$this->request = $request;
    }
    /**
    * @param Route $route
    * @return Router
    */
    public function add(Route $route)
    {
    	if (!isset($this->routes[$route->getName()]))
	    {
			return $this->routes[$route->getName()] = $route;
	    }
    }
    /**
    * @return Route
    */
    public function find()
    {
    	foreach ($this->routes as $route) 
    	{
    		if ($route->match($this->request->getUri())) 
    		{
    			return $route;
    		}
    	}
    }
}