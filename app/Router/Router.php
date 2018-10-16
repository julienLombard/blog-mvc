<?php
namespace App\Router;

use App\Request;
use App\Router\Route;
use Symfony\Component\Yaml\Yaml;

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
                    if ($route->isGranted($request) == true) {

                        return $route;
                    } else {

                        // Loading config file and Instantiating new Route
                        $route = parse_ini_file(__DIR__."/../../config/redirect.ini");
                        $route = new Route($route['name'], $route['path'], $route['parameters'], $route['controller'], $route['action'], $route['security']);
                        
                        // Redirect Route
                        return $this->add($route);
                    }                   
                } else {

                    return $route;
                }
    		}
    	}
    }
    /**
     * @param string $file
     */
    public function loadYaml($file)
    {
        // loading routing.yml file
        $routes = Yaml::parseFile($file);
        foreach($routes as $name => $route){
            $this->add(new Route($name, $route["path"], $route["parameters"], $route["controller"], $route["action"], $route["security"], $route["args"] ?? null));
        }
    }
}