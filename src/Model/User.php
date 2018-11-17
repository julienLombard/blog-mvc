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
	* @var \DateTime
	*/
	private $registerDate;
	/**
	* @var integer
	*/
	private $validate;
	/**
	* @var integer
	*/
	private $administrator;

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
			"table" => "user",
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
				],

				"register_date" => 
				[
					"type" => "datetime",
					"property" => "registerDate"
				],

				"validate" => 
				[
					"type" => "integer",
					"property" => "validate"
				],

				"administrator" => 
				[
					"type" => "integer",
					"property" => "administrator"
				]
			]
		];
	}

	/**
	* @param integer $id
	* @return void
	*/
	public function setId(int $id)
	{
		$this->id = $id;
	}

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

	/**
	* @param \DateTime $registerDate
	* @return void
	*/
	public function setRegisterDate(\DateTime $registerDate)
	{
		$this->registerDate = $registerDate;
	}

	/**
	* @return \DateTime
	*/
	public function getRegisterDate()
	{
		return $this->registerDate;
	}

	/**
	* @param integer $validate
	* @return void
	*/
	public function setValidate(int $validate)
	{
		$this->validate = $validate;
	}

	/**
	* @return integer
	*/
	public function getValidate()
	{
		return $this->validate;
	}

	/**
	* @param integer $administrator
	* @return void
	*/
	public function setAdministrator(int $administrator)
	{
		$this->administrator = $administrator;
	}

	/**
	* @return integer
	*/
	public function getAdministrator()
	{
		return $this->administrator;
	}
}