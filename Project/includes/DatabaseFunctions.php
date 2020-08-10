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

function insertJoke($pdo, $text, $author)
{
    $sql = 'INSERT INTO `joke` (`joketext`, `jokedate`, `authorid`) VALUES (:joketext, CURDATE(), ' . $author . ')';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':joketext', $text);
    $stmt->execute();
}

function editJoke($pdo, $id, $text, $authorid)
{
    $sql = 'UPDATE `joke`
            SET
                `joketext` = :text,
                `authorid` = :authorid
            WHERE `id` = :id';
    $parameters = [':text' => $text, ':authorid' => $authorid, ':id' => $id];
    query($pdo, $sql, $parameters);
}
