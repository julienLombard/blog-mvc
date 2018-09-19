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
    public function getConnection(string $login, string $password) 
    {
        $statement = $this->database->getPdo()->prepare("SELECT * FROM user WHERE login = :login AND password = :password" );
        $statement->execute(["login" => $login, "password" => $password]);

        return $result = $statement->fetch();
    }
}