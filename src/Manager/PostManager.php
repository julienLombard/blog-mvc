<?php

namespace Manager;

use App\ORM\Manager;
use Model\Post;

/**
* Class PostManager
* @package Manager
*/
class PostManager extends Manager
{
    /**
    * @param integer $page
    * @param integer $offset
    * @param integer $length 
    * @param string $property
    * @param string $order
    * @param string $property2
    * @param string $var
    * @return array
    */
    public function getPagination($page, ?int $offset, ?int $length, ?string $property, ?string $order, ?string $property2, ?string $var) 
    {
        $offset = ($page-1)*$length;

        $results = $this->findAll($offset, $length, $property, $order, $property2, $var, null, null);

        return $results;
    }

    /**
    * @return integer
    */
    public function countAllPost()
    {
        $statement = $this->database->getPdo()->prepare("SELECT COUNT(*) as total FROM post" );
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC)["total"];
    }
}