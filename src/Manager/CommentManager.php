<?php

namespace Manager;

use App\ORM\Manager;
use Model\Comment;

/**
* Class CommentManager
* @package Manager
*/
class CommentManager extends Manager
{
    /**
    * @param integer $page
    * @param integer $offset
    * @param integer $length 
    * @param string $property
    * @param string $order
    * @param string $property2
    * @param string $var
    * @param string $property3
    * @param string $var2
    * @return array
    */
    public function getPagination($page, ?int $offset, ?int $length, ?string $property, ?string $order, ?string $property2, ?string $var, ?string $property3, ?string $var2) 
    {
        $offset = ($page-1)*$length;

        $results = $this->findAll($offset, $length, $property, $order, $property2, $var, $property3, $var2);

        return $results;
    }

    /**
    * @param integer $id
    * @return integer
    */
    public function countByPost($id)
    {
        $statement = $this->database->getPdo()->prepare("SELECT COUNT(*) as total FROM comment WHERE post_id = :post_id" );
        $statement->execute(["post_id" => $id]);

        return $statement->fetch(\PDO::FETCH_ASSOC)["total"];
    }

    /**
    * @param integer $id
    * @return integer
    */
    public function countValidByPost($id)
    {
        $statement = $this->database->getPdo()->prepare("SELECT COUNT(*) as total FROM comment WHERE post_id = :post_id AND validate = 1" );
        $statement->execute(["post_id" => $id]);

        return $statement->fetch(\PDO::FETCH_ASSOC)["total"];
    }

    /**
    * @param string $property
    * @param integer $nb
    * @return integer
    */
    public function countAllComment($property, $nb)
    {
        $statement = $this->database->getPdo()->prepare("SELECT COUNT(*) as total FROM comment WHERE $property = $nb" );
        $statement->execute();
        
        return $statement->fetch(\PDO::FETCH_ASSOC)["total"];
    }
}