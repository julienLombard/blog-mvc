<?php

namespace App\ORM;

use App\ORM\Database;

/**
* Class Manager
* @package App\ORM
*/
class Manager
{
    use Traits\QueryBuilder;

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

    /**
    * @param integer $pkValue 
    * @return Model
    */
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
            }
            return $obj;
        }
        return null;
    }

    /**
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
    public function findAll(?int $offset, ?int $length, ?string $property, ?string $order, ?string $property2, ?string $var, ?string $property3, ?string $var2)
    {

        $limit = $this->limit($offset, $length);
        $orderBy = $this->orderBy($property, $order);
        $where = $this->where($property2, $var);
        $and = $this->and($property3, $var2);

        $results = $this->fetchAll($where, $and, $orderBy, $limit);

        $data = $this->hydrate($results);
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