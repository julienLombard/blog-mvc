<?php

namespace App\Response;

/**
* Class RedirectResponse
* @package App\Response
*/
class RedirectResponse implements ResponseInterface
{
	/**
	* @var string
	*/
	private $url;
	/**
	 * Route constructor.
	 * @param string $url
	 */
	public function __construct($url)
	{
		$this->url = $url;
	}

	public function send() 
	{
		header("Location: " . $this->url);
	}
}