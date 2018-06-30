<?php
namespace App\Router;

use App\Request;

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
	* @var array|string|mixed
	*/
	private $args;
	/**
	 * Route constructor.
	 * @param string $path
	 * @param array $parameters
	 * @param string $controller
	 * @param string $action
	 */
	public function __construct($name, $path, array $parameters, $controller, $action)
	{
		$this->name = $name;
		$this->path = $path;
		$this->parameters = $parameters;
		$this->controller = $controller;
		$this->action = $action;
	}
	/**
	* @return boolean
	*/
	public function match($requestUri)
	{
		$pattern = preg_replace_callback("/:(\w+)/", array($this, "checkParameters"), $this->path);

		$pattern = preg_replace("~/~", "\/", $pattern);

		if(!preg_match("/^$pattern$/i", $requestUri, $matches))
		{
			return false;
		}
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
     		return '([^/]+)';
     	}
     }
    /**
	* @return ResponseInterface
	*/
	public function call($request)
	{

	}
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
}