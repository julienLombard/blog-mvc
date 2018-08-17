<?php

namespace App\ORM;

use App\ORM\Database;

/**
* Class Manager
* @package App\ORM
*/
class Manager
{
    /**
    * @var Database
    */
    protected $database;
    /**
    * @var string
    */
    private $model;
    /**
    * @var array
    */
    private $metadata;

    /**
    * Manager constructor.
    * @param Database $database
    * @param $model
    */
    public function __construct(Database $database, $model)
    {
        $this->database = $database;
        $reflectionClass = new \ReflectionClass($model);
        if($reflectionClass->getParentClass()->getName() == Model::class) {
            $this->model = $model;
            $this->metadata = $this->model::metadata();
        }
        $this->model = $model;
    }

    public function find($pkValue)
    {
        $query = sprintf("SELECT * FROM %s WHERE %s = :pkValue", $this->model::metadata()["table"], $this->model::metadata()["primaryKey"]);
        $statement = $this->database->getPdo()->prepare($query);
        $statement->execute([
            "pkValue" => $pkValue
        ]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($result) 
        {
            $obj = new $this->model();
            $columns = $this->model::metadata()["columns"];
            foreach ($result as $column => $value) 
            {
                switch ($columns[$column]["type"]) 
                {
                    case 'integer':
                        $value = (int) $value;                
                        break;                                      
                    case 'datetime':
                        if ($value) 
                        {
                            $value = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                            break;
                        }
                        break;
                }
                $obj->{sprintf("set%s", ucfirst($columns[$column]["property"]))}($value);
                // var_dump($column . " => " . $value);
            }
            return $obj;
        }
        return null;
    }

    public function findAll(?int $offset, ?int $length, ?string $property, ?string $order)
    {
        if($offset !== null && $length !== null) 
        {
            $limit = sprintf("LIMIT %s, %s", $offset, $length);
        } else 
        {
            $limit = "";
        }

        $orderBy = "";
        if($property !== null && $order !== null) 
        {
            $columns = $this->model::metadata()["columns"];
            foreach($columns as $column => $definition)
            {
                if($definition["property"] == $property)
                {
                    $orderBy = sprintf("ORDER BY %s %s", $column, $order);
                }
            } 
        }
        $query = sprintf("SELECT * FROM %s %s %s",  $this->model::metadata()["table"], $orderBy , $limit);
        
        $statement = $this->database->getPdo()->prepare($query);
        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $data = [];
        foreach($results as $result) 
        {
            $obj = new $this->model();
            $columns = $this->model::metadata()["columns"];
            foreach($result as $column => $value) 
            {
                switch ($columns[$column]["type"]) 
                {
                    case 'integer':
                        $value = (int) $value;                     
                        break;                                      
                    case 'datetime':
                        if ($value) 
                        {
                            $value = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                            break;
                        }
                        break;
                }
                $obj->{sprintf("set%s", ucfirst($columns[$column]["property"]))}($value);
            }
            $data[] = $obj;
        }
        return $data;
    }

    /**
    * @param Model $model
    */
    public function insert(Model $model)
    {
        $modelMetadata = $model::metadata();
        $tableName = $modelMetadata["table"];
        $columns = [];
        $parameters = [];
        $data = [];

        foreach ($modelMetadata["columns"] as $column => $definition) {
            if ($modelMetadata["primaryKey"] !== $column) 
            {
                $columns[] = $column;
                $parameters[] = ":" . $column;

                $value = null;
                switch ($definition["type"]) 
                {
                    case 'integer':
                        $value = (int) $model->{sprintf("get%s", ucfirst($definition["property"]))}();
                        break;

                    case 'string':
                        $value = (string) $model->{sprintf("get%s", ucfirst($definition["property"]))}();
                        break;

                    case 'datetime':
                        if ($model->{sprintf("get%s", ucfirst($definition["property"]))}() != null) 
                        {
                            $value = $model->{sprintf("get%s", ucfirst($definition["property"]))}()->format("Y-m-d H:i:s");
                            break;    
                        }
                    break; 
                }

                $data[$column] = $value;
            }
        }

        $query = sprintf(
                "INSERT INTO %s(%s) VALUES(%s)",
                $tableName,
                implode(",", $columns),
                implode(",", $parameters)
                );
        var_dump($query, $data);

        $statement = $this->database->getPdo()->prepare($query);
        $statement->execute($data);
    }

    /**
    * @param Model $model
    */
    public function update(Model $model)
    {
        $modelMetadata = $model::metadata();
        $primaryKey = $modelMetadata["columns"][$modelMetadata["primaryKey"]]["property"];

        $tableName = $modelMetadata["table"];
        $sets = [];
        $data = [
            "primaryKey" => $model->{sprintf("get%s", ucfirst($primaryKey))}()
        ];
        foreach ($modelMetadata["columns"] as $column => $definition) {
            if ($modelMetadata["primaryKey"] !== $column) 
            {
                $sets[] = sprintf("%s=:%s", $column, $column);
                $value = null;

                switch ($definition["type"]) 
                {
                    case 'integer':
                        $value = (int) $model->{sprintf("get%s", ucfirst($definition["property"]))}();
                        break;

                    case 'string':
                        $value = (string) $model->{sprintf("get%s", ucfirst($definition["property"]))}();
                        break;

                    case 'datetime':
                        if ($model->{sprintf("get%s", ucfirst($definition["property"]))}() !== null) 
                        {
                            $value = $model->{sprintf("get%s", ucfirst($definition["property"]))}()->format("Y-m-d H:i:s");
                            break;    
                        }
                        break; 
                }

                $data[$column] = $value;
            }
        }

        $query = sprintf(
                "UPDATE %s SET %s WHERE %s=:primaryKey",
                $tableName,
                implode(",", $sets),
                $modelMetadata["primaryKey"]
                );
        // var_dump($query, $data);

        $statement = $this->database->getPdo()->prepare($query);
        $statement->execute($data);
    }

    /**
    * @param Model $model
    */
    public function delete(Model $model)
    {
        $modelMetadata = $model::metadata();
        $primaryKey = $modelMetadata["columns"][$modelMetadata["primaryKey"]]["property"];

        $tableName = $modelMetadata["table"];
        $sets = [];
        $data = [
            "primaryKey" => $model->{sprintf("get%s", ucfirst($primaryKey))}()
        ];

        $query = sprintf(
                "DELETE FROM %s WHERE %s=:primaryKey",
                $tableName,
                $modelMetadata["primaryKey"]
                );

        $statement = $this->database->getPdo()->prepare($query);
        $statement->execute($data);
    }
}