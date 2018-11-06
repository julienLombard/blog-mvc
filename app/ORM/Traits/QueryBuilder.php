<?php

namespace App\ORM\Traits;

trait QueryBuilder {

    public function limit(?int $offset, ?int $length) {

        if($offset !== null && $length !== null) 
        {
            return sprintf("LIMIT %s, %s", $offset, $length);
        } else 
        {
            return "";
        }
    }

    public function orderBy(?string $property, ?string $order) {

        if($property !== null && $order !== null) 
        {
            $columns = $this->model::metadata()["columns"];
            foreach($columns as $column => $definition)
            {
                if($definition["property"] == $property)
                {
                    return sprintf("ORDER BY %s %s", $column, $order);
                }
            } 
        } else {
            return "";
        }
    }

    public function where(?string $property2, ?string $var) {

        if($property2 !== null && $var !== null) 
        {
            $columns = $this->model::metadata()["columns"];
            foreach($columns as $column => $definition)
            {
                if($definition["property"] == $property2)
                {
                    return sprintf("WHERE %s = %s", $column, $var);
                }
            } 
        } else {
            return "";
        }
    }

    public function and(?string $property3, ?string $var2) {

        if($property3 !== null && $var2 !== null) 
        {
            $columns = $this->model::metadata()["columns"];
            foreach($columns as $column => $definition)
            {
                if($definition["property"] == $property3)
                {
                    return sprintf("AND %s = %s", $column, $var2);
                }
            } 
        } else {
            return "";
        }
    }

    public function fetchAll($where, $and = null, $orderBy = null, $limit = null) {

        $query = sprintf("SELECT * FROM %s %s %s %s %s",  $this->model::metadata()["table"], $where, $and, $orderBy, $limit);
        
        $statement = $this->database->getPdo()->prepare($query);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function hydrate($results) {

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
}