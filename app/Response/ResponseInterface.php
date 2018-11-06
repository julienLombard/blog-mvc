<?php

namespace App\Response;

/**
* Interface ResponseInterface
* @package App\Response
*/
interface ResponseInterface 
{
	/**
	* @return void
	*/
	public function send();
}