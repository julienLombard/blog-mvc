<?php

namespace Model;

use App\ORM\Model;
use Manager\UserManager;

/**
* Class User
* @package Model
*/
class User extends Model
{

	/**
	* @var integer
	*/
	private $id;
	/**
	* @var string
	*/
	private $login;
	/**
	* @var string
	*/
	private $password;

	/**
	* @return inheritdoc
	*/
	public static function getManager()
	{
		return UserManager::class;
	}

	/**
	* @return array
	*/
	public static function metadata()
	{
		return [
			"table" => "post",
			"primaryKey" => "id",
			"columns" => 
			[
				"id" => 
				[
					"type" => "integer",
					"property" => "id"
				],

				"login" => 
				[
					"type" => "string",
					"property" => "login"
				],

				"password" => 
				[
					"type" => "string",
					"property" => "password"
				]
			]
		];
	}

	// /**
	// * @param integer $id
	// * @return void
	// */
	// public function setId(int $id)
	// {
	// 	$this->id = $id;
	// }

	/**
	* @return integer
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* @param string $login
	* @return void
	*/
	public function setLogin(string $login)
	{
		$this->login = $login;
	}

	/**
	* @return string
	*/
	public function getLogin()
	{
		return $this->login;
	}

	/**
	* @param string $password
	* @return void
	*/
	public function setPassword(string $password)
	{
		$this->password = $password;
	}

	/**
	* @return string
	*/
	public function getPassword()
	{
		return $this->password;
	}
}