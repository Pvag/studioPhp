<?php

// ----------- generic functions -----------

function query($pdo, $sql, $parameters = [])
{
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function processDates($fields)
{
    foreach ($fields as $key => $value) {
        if ($value instanceof DateTime) {
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    return $fields;
}

// replaces both 'allJokes' and 'allAuthors'
function findAll($pdo, $table)
{
    $sql = 'SELECT * FROM ' . $table;
    $result = query($pdo, $sql);
    return $result->fetchAll();
}

// replaces both 'deleteJoke' and 'deleteAuthor'
function delete($pdo, $table, $primaryKey, $id)
{
    $sql = 'DELETE FROM ' . $table . ' WHERE ' . $primaryKey . ' = ' . ':primaryKey';
    $params = ['primaryKey' => $id];
    query($pdo, $sql, $params);
}

// replaces both 'insertJoke' and 'insertAuthor'
function insert($pdo, $table, $params)
{
    $sql = 'INSERT INTO ' . $table . ' SET ';
    foreach ($params as $key => $value) {
        $sql .= $key . ' = :' . $key . ',';
    }
    $sql = rtrim($sql, ',');
    $params = processDates($params);
    query($pdo, $sql, $params);
}

// replaces 'getJoke'
function findById($pdo, $table, $primaryKey, $id)
{
    $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $primaryKey . ' = :primaryKey';
    $params = ['primaryKey' => $id];
    $result = query($pdo, $sql, $params);
    return $result->fetch(PDO::FETCH_ASSOC);
}

// replaces 'updateJoke'
function update()
{
}

// replaces 'totalJokes'
function total($pdo, $table)
{
    $sql = 'SELECT COUNT(*) FROM ' . $table;
    $result = query($pdo, $sql);
    return $result->fetch()[0];
}

// ----------- end of generic functions -----------


// ----------- specialized functions (i.e. that are specific to the example at hand - the Internet Jokes Database ) -----------

function totalJokes($pdo)
{
    $sql = 'SELECT COUNT(*) FROM `joke`';
    $query = query($pdo, $sql);
    return $query->fetch()[0];
}

function getJoke($pdo, $id)
{
    $sql = 'SELECT * FROM `joke` WHERE `id` = :id';
    $parameters = [':id' => $id];
    $query = query($pdo, $sql, $parameters);
    $row = $query->fetch();
    return $row;
}

// example call:
// insertJoke($pdo, [authorid => 5, joketext='blablabla', 'jokedate' = new DateTime()]);
function insertJoke($pdo, $fields)
{
    $sql = 'INSERT INTO `joke` (';
    foreach ($fields as $key => $value) {
        $sql .= '`' . $key . '`,';
    }
    $sql = rtrim($sql, ',');
    $sql .= ') VALUES (';
    foreach ($fields as $key => $value) {
        $sql .= ':' . $key . ',';
    }
    $sql = rtrim($sql, ',');
    $sql .= ')';

    // this function does not require a specific format for the date passed as argument, but MySQL does!
    $fields = processDates($fields);

    query($pdo, $sql, $fields);
}

function updateJoke($pdo, $fields)
{
    $sql = 'UPDATE `joke` SET ';
    foreach ($fields as $key => $value) {
        $sql .= $key . '=' . ':' . $key . ','; // *
    }
    $sql = rtrim($sql, ',');
    $sql .= ' WHERE `id` = :primarykey'; // ':id' has been already used ! *
    $fields['primarykey'] = $fields['id']; // *

    $fields = processDates($fields);

    query($pdo, $sql, $fields);
}

function deleteJoke($pdo, $id)
{
    $sql = 'DELETE FROM `joke` WHERE `id` = :id';
    $parameters = [':id' => $id];
    query($pdo, $sql, $parameters);
}

function allJokes($pdo)
{
    $sql = 'SELECT `joke`.`id`, `joketext`, `jokedate`, `name`, `email`
                FROM `ijdb`.`joke` INNER JOIN `ijdb`.`author` ON `joke`.`authorid` = `author`.`id`';
    $result = query($pdo, $sql);
    return $result->fetchAll();
}

// functions that work on the author db

function allAuthors($pdo)
{
    $sql = 'SELECT * FROM `author`';
    $query = query($pdo, $sql);
    return $query->fetchAll(PDO::FETCH_ASSOC); // if param is not provided in fetchAll, I get a text key and a numeric key for each column of each element that was fetched
}

function deleteAuthor($pdo, $id)
{
    $params = ['id' => $id];
    $sql = 'DELETE FROM `author` WHERE `id` = :id';
    query($pdo, $sql, $params);
}

function insertAuthor($pdo, $params)
{
    $sql = 'INSERT INTO `author` SET ';
    foreach ($params as $key => $value) {
        $sql .= $key . ' = :' . $key;
    }
    $params = processDates($params);
    query($pdo, $sql, $params);
}


// ----------- end of specialized functions -----------