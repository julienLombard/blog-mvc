<?php

namespace App\ORM;

use App\Request;

/**
* Class Database
* @package App\ORM
*/
class Database
{
    /**
    * @var \PDO
    */
    private $pdo; 
    /**
    * @var Database
    */
    private static $databaseInstance;
    /**
    * @var array
    */
    private $managers;

    /**
    * @param Request $request
    * @param DatabaseInstance
    */
    public static function getInstance(Request $request)
    {
        if(self::$databaseInstance === null) {
            self::$databaseInstance = new Database(
                $request->getEnv("DB_HOST"),
                $request->getEnv("DB_NAME"),
                $request->getEnv("DB_USER"),
                $request->getEnv("DB_PASSWORD")
            );
        }
        return self::$databaseInstance;
    }

    /**
    * Database constructor.
    * @param string $host
    * @param string $dbName
    * @param string $user
    * @param string $password
    */
    public function __construct($host, $dbName, $user, $password)
    {
        $this->pdo = new \PDO("mysql:host=" . $host . ";dbname=" . $dbName . ";charset=utf8", $user, $password);
    }

    /**
    * @return \PDO
    */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
    * @return Manager
    */
    public function getManager($model)
    {
        $managerClass = $model::getManager();
        $this->managers[$managerClass] = $this->managers[$managerClass] ?? new $managerClass($this, $model);
        return $this->managers[$managerClass];
    }
}