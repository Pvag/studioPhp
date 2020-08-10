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
    foreach ($parameters as $key => $value) {
        $query->bindValue($key, $value);
    }
    $query->execute();
    return $query;
}
