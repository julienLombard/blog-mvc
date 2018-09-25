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
    public function getPagination($page, ?int $offset, ?int $length, ?string $property, ?string $order, ?string $property2, ?string $var, ?string $property3, ?string $var2) 
    {
        $offset = ($page-1)*$length;

        $results = $this->findAll($offset, $length, $property, $order, $property2, $var, $property3, $var2);
        // var_dump($results);
        // exit;
        return $results;
    }

    public function countByPost($id)
    {
        $statement = $this->database->getPdo()->prepare("SELECT COUNT(*) as total FROM comment WHERE post_id = :post_id" );
        $statement->execute(["post_id" => $id]);

        return $statement->fetch(\PDO::FETCH_ASSOC)["total"];
    }

    public function countAllComment($property, $nb)
    {
        $statement = $this->database->getPdo()->prepare("SELECT COUNT(*) as total FROM comment WHERE $property = $nb" );
        $statement->execute();
        // $statement->execute(["property" => $property, "nb" => $nb]));
        
        return $statement->fetch(\PDO::FETCH_ASSOC)["total"];
    }
}