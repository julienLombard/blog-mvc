<?php

namespace App\Response

/**
* Class Response
* @package App\Response
*/
class Response implements ResponseInterface
{
	/**
	* @var string
	*/
	private $content;
	/**
	 * Route constructor.
	 * @param string $content
	 */
	public function __construct($content)
	{
		$this->content = $content;
	}
	/**
	* @return $content
	*/
	public function send()
	{
		return $this->content;
	}
}