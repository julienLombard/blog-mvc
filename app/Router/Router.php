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
    // /**
    // * @return Route
    // */
    // public function find()
    // {
    // 	foreach ($this->routes as $route) 
    // 	{
    // 		if ($route->match($this->request->getPath())) 
    // 		{
    // 			return $route;
    // 		}
    // 	}
    // }

    /**
    * @param Request $request
    * @return Route
    */
    public function find(Request $request)
    {
    	foreach ($this->routes as $route) 
    	{

            if ($route->match($this->request->getPath())) 
    		{
                if ($route->getSecurity() == true) 
                {
                    if ($route->isLogged($request) == true) {

                        return $route;

                    } else {

                        return $this->routes["admin_user_connection"];

                    }
                    
                } else {

                    return $route;
                }
    		}
    	}
    }

    /**
    * @param string $routeName
    * @return Route
    */
    public function getRoute($routeName)
    {
        if (isset($this->routes[$routeName]))
        {
            return $this->routes[$routeName];
        }
    }
}