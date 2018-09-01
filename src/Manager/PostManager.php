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
    public function getPagination($page, ?int $offset, ?int $length, ?string $property, ?string $order) 
    {
        $offset = ($page-1)*$length;

        $results = $this->findAll($offset, $length, $property, $order);

        return $results;
    }
}