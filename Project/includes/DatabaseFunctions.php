<?php

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

function query($pdo, $sql, $parameters = [])
{
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function formatDates($fields)
{
    foreach ($fields as $key => $value) {
        if ($value instanceof DateTime) {
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    return $fields;
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
    $fields = formatDates($fields);

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

    $fields = formatDates($fields);

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
