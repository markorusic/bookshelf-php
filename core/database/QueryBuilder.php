<?php

namespace App\Core\Database;

use PDO;

class QueryBuilder
{
    private static function mapQuery($params, $partSeparator, $implodeGlue)
    {
        $parts = [];
        foreach ($params as $key => $value) {
            array_push($parts, $key . $partSeparator . ':' . $key);
        }
        return implode($implodeGlue, $parts);
    }

    private static function parseValues($values)
    {
        $parsed = [];
        foreach ($values as $key => $value) {
            $val = $value;
            if (is_bool($value)) {
                $val = (int) $value;
            }
            $parsed[$key] = $val;
        }
        return $parsed;
    }

    /**
     * The PDO instance.
     *
     * @var PDO
     */
    public $pdo;

    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Select all records from a database table.
     *
     * @param string $table
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Select records from a database table by array of parameters.
     *
     * @param string $table
     * @param array $parameters
     */
    public function selectWhere($table, $parameters)
    {
        $where = "";
        if (count($parameters) > 0) {
            $where = " where " . self::mapQuery($parameters, "=", " and ");
        }
        $sql = "select * from {$table}{$where}";

        $statement = $this->pdo->prepare($sql);

        $statement->execute($parameters);

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Select records from a database table by array of parameters.
     *
     * @param string $table
     * @param array $parameters
     */
    public function selectPage($table, $parameters)
    {
        $page = isset($parameters['page']) ? $parameters['page'] : 0;
        $size = isset($parameters['size']) ? $parameters['size'] : 10;
        $offset = $page * $size;
        $options = $parameters['options'];

        $bindValues = [];
        $where = "";
        if (count($parameters) > 0) {
            $where = " where ";
            foreach ($options as $option) {
                $bindValues[$option[0]] = $option[2];
                $where .= "{$option[0]} $option[1] :$option[0]";
            }
        }

        $order = "";
        if (!is_null($parameters['sort'])) {
            $sortTuple = explode(',', $parameters['sort']);
            $order = " order by {$sortTuple[0]} {$sortTuple[1]}";
        }
        
        $sql = "select * from {$table}{$where}{$order} limit {$size} offset {$offset}";

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindValues);

        $content = $statement->fetchAll(PDO::FETCH_CLASS);

        $totalElementsStatement = $this->pdo->prepare("SELECT count(*) FROM {$table}${where}");
        $totalElementsStatement->execute($bindValues);
        $totalElements = $totalElementsStatement->fetchColumn();

        $pagination = compact('page', 'size', 'totalElements');
        return compact('content', 'pagination');
    }

    /**
     * Insert a record into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        $statement = $this->pdo->prepare($sql);
        $statement->execute(self::parseValues($parameters));
        return $this->pdo->lastInsertId();
    }

    /**
     * Update a record into a table.
     *
     * @param  array  $updateParameters
     * @param  array  $whereParameters
     */
    public function update($table, $updateParameters, $whereParameters)
    {
        $paramsToUpdate = self::mapQuery($updateParameters, "=", ",");
        $where = "";

        if (count($whereParameters) > 0) {
            $whereParts = [];
            foreach ($whereParameters as $key => $value)
            {
                array_push($whereParts, $key . '=:where_' . $key);
                $whereParameters['where_'.$key] = $value;
                unset($whereParameters[$key]);
            }
            $where = " where " . implode('and', $whereParts);
        }

        $sql = "update {$table} set {$paramsToUpdate}{$where}";

        $statement = $this->pdo->prepare($sql);

        return $statement->execute(self::parseValues(array_merge($updateParameters, $whereParameters)));
    }

     /**
     * Delete selected records from a database table.
     *
     * @param string $table
     * @param  array  $parameters
     */
    public function deleteWhere($table, $parameters)
    {
        $where = "";

        if (count($parameters) > 0) {
            $where = " where " . self::mapQuery($parameters, "=", " and ");
        }

        $sql = "delete from {$table}{$where}";

        $statement = $this->pdo->prepare($sql);

        return $statement->execute($parameters);
    }

    /**
     * Determin weather selected record exists in a database table.
     *
     * @param string $table
     * @param  array  $parameters
     */
    public function exists($table, $parameters)
    {
        $result = $this->selectWhere($table, $parameters);
        return $result && count($result) > 0;
    }
}
