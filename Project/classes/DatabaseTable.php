<?php

class DatabaseTable
{
    private $pdo;
    private $table;
    private $primaryKey;

    public function __construct(PDO $pdo, string $table, string $primaryKey)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    private function query($sql, $parameters = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }

    private function processDates($fields)
    {
        foreach ($fields as $key => $value) {
            if ($value instanceof DateTime) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }

    public function save($params)
    {
        $primaryKey = $this->primaryKey;
        try {
            if ($params[$primaryKey] == '') {
                $params[$primaryKey] = null; // take advantage of mysql's auto increment for the new primary key
            }
            // if the value provided for the primary key inside $params already exists in the db,
            // the code in the 'catch' block is executed, performing an update of an existing value
            $this->insert($params);
        } catch (PDOException $e) {
            $this->update($params);
        }
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM ' . $this->table;
        $result = $this->query($sql);
        return $result->fetchAll();
    }

    function delete($id)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = ' . ':primaryKey';
        $params = ['primaryKey' => $id];
        $this->query($sql, $params);
    }

    function insert($params)
    {
        $sql = 'INSERT INTO ' . $this->table . ' SET ';
        foreach ($params as $key => $value) {
            $sql .= $key . ' = :' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        $params = $this->processDates($params);
        $this->query($sql, $params);
    }

    function findById($id)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :primaryKey';
        $params = ['primaryKey' => $id];
        $result = $this->query($sql, $params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    function update($params)
    {
        $sql = 'UPDATE ' . $this->table . ' SET ';
        foreach ($params as $key => $value) {
            $sql .= $key . '=:' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE ' . $this->primaryKey . ' = :primarykey';
        $params['primarykey'] = $params[$this->primaryKey];
        $params = $this->processDates($params);
        $this->query($sql, $params);
    }

    function total()
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->table;
        $result = $this->query($sql);
        return $result->fetch()[0];
    }
}
