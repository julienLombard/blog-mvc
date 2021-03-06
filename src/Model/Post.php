<?php

namespace Model;

use App\ORM\Model;
use Manager\PostManager;

/**
* Class Post
* @package Model
*/
class Post extends Model
{

	/**
	* @var integer
	*/
	private $id;
	/**
	* @var string
	*/
	private $title;
	/**
	* @var string
	*/
	private $author;
	/**
	* @var string
	*/
	private $synopsis;
	/**
	* @var string
	*/
	private $content;
	/**
	* @var \DateTime
	*/
	private $publicationDate;
	/**
	* @var \DateTime
	*/
	private $modificationDate;

	/**
	* @return inheritdoc
	*/
	public static function getManager()
	{
		return PostManager::class;
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

				"title" => 
				[
					"type" => "string",
					"property" => "title"
				],		
				
				"author" => 
				[
					"type" => "string",
					"property" => "author"
				],	

				"synopsis" => 
				[
					"type" => "string",
					"property" => "synopsis"
				],

				"content" => 
				[
					"type" => "string",
					"property" => "content"
				],

				"publication_date" => 
				[
					"type" => "datetime",
					"property" => "publicationDate"
				],

				"modification_date" => 
				[
					"type" => "datetime",
					"property" => "modificationDate"
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
	* @param string $title
	* @return void
	*/
	public function setTitle(string $title)
	{
		$this->title = $title;
	}

	/**
	* @return string
	*/
	public function getTitle()
	{
		return $this->title;
	}

	/**
	* @param string $author
	* @return void
	*/
	public function setAuthor(string $author)
	{
		$this->author = $author;
	}

	/**
	* @return string
	*/
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	* @param string $synopsis
	* @return void
	*/
	public function setSynopsis(string $synopsis)
	{
		$this->synopsis = $synopsis;
	}

	/**
	* @return string
	*/
	public function getSynopsis()
	{
		return $this->synopsis;
	}

	/**
	* @param string $content
	* @return void
	*/
	public function setContent(string $content)
	{
		$this->content = $content;
	}

	/**
	* @return string
	*/
	public function getContent()
	{
		return $this->content;
	}

	/**
	* @param \DateTime $publicationDate
	* @return void
	*/
	public function setPublicationDate(\DateTime $publicationDate)
	{
		$this->publicationDate = $publicationDate;
	}

	/**
	* @return \DateTime
	*/
	public function getPublicationDate()
	{
		return $this->publicationDate;
	}

	/**
	* @param \DateTime $ModificationDate
	* @return void
	*/
	public function setModificationDate(?\DateTime $modificationDate)
	{
		$this->modificationDate = $modificationDate;
	}

	/**
	* @return \DateTime
	*/
	public function getModificationDate()
	{
		return $this->modificationDate;
	}
}