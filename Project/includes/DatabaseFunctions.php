<?php

function totalJokes($pdo)
{
    $sql = 'SELECT COUNT(*) FROM `joke`';
    $query = $pdo->prepare($sql);
    $query->execute();
    return $query->fetch()[0];
}

function getJoke($pdo, $jokeId)
{
    $sql = 'SELECT * FROM `joke` WHERE `id` = :jokeid';
    $query = $pdo->prepare($sql);
    $query->bindValue(':jokeid', $jokeId);
    $query->execute();
    $row = $query->fetch();
    return $row;
}
