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
    * @var \PDO
    */
    protected $pdo;
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
    * @param \PDO $pdo
    * @param $model
    */
    public function __construct(\PDO $pdo, $model)
    {
        $this->pdo = $pdo;
        $reflectionClass = new \ReflectionClass($model);
        if($reflectionClass->getParentClass()->getName() == Model::class) {
            $this->model = $model;
            $this->metadata = $this->model->metadata();
        }
        $this->model = $model;
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

        $statement = $this->pdo->prepare($query);
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
        var_dump($query, $data);

        $statement = $this->pdo->prepare($query);
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

        $statement = $this->pdo->prepare($query);
        $statement->execute($data);
    }
}