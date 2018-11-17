<?php

namespace Manager;

use App\ORM\Manager;
use Model\User;

/**
* Class UserManager
* @package Manager
*/
class UserManager extends Manager
{
    /**
    * @param string $login
    * @param string $password
    * @return Model   
    */
    public function getConnection(string $login, string $password) 
    {
        $statement = $this->database->getPdo()->prepare("SELECT * FROM user WHERE login = :login AND password = md5(:password)" );
        $statement->execute(["login" => $login, "password" => $password]);

        return $result = $statement->fetch();
    }

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
    public function countAllUsers()
    {
        $statement = $this->database->getPdo()->prepare("SELECT COUNT(*) as total FROM user" );
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC)["total"];
    }
}