<?php

namespace App\ORM;

/**
* Class Model
* @package App\ORM
*/
abstract class Model 
{
	/**
	* @return array
	*/
	public abstract static function metadata();

	/**
	* @return string
	*/
	public abstract static function getManager();
}