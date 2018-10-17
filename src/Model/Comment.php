<?php

namespace Model;

use App\ORM\Model;
use Manager\CommentManager;

/**
* Class Post
* @package Model
*/
class Comment extends Model
{

	/**
	* @var integer
	*/
	private $id;
	/**
	* @var integer
	*/
	private $postId;
	/**
	* @var string
	*/
	private $author;
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
	* @var integer
	*/
	private $validate;
    /**
	* @var integer
	*/
	private $reported;

	/**
	* @return inheritdoc
	*/
	public static function getManager()
	{
		return CommentManager::class;
    }

	/**
	* @return array
	*/
	public static function metadata()
	{
		return [
			"table" => "comment",
			"primaryKey" => "id",
			"columns" => 
			[
				"id" => 
				[
					"type" => "integer",
					"property" => "id"
				],
				
				"post_id" => 
				[
					"type" => "integer",
					"property" => "postId"
				],

				"author" => 
				[
					"type" => "string",
					"property" => "author"
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
                ],
                
                "validate" => 
				[
					"type" => "integer",
					"property" => "validate"
				],

                "reported" => 
				[
					"type" => "integer",
					"property" => "reported"
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
	* @param integer $id
	* @return void
	*/
	public function setPostId(int $postId)
	{
		$this->postId = $postId;
	}

	/**
	* @return integer
	*/
	public function getPostId()
	{
		return $this->postId;
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
	* @param integer $reported
	* @return void
	*/
	public function setReported(int $reported)
	{
		$this->reported = $reported;
	}

	/**
	* @return integer
	*/
	public function getReported()
	{
		return $this->reported;
	}
}