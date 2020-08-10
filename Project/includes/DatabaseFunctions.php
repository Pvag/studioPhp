<?php

function totalJokes($pdo)
{
    $sql = 'SELECT COUNT(*) FROM `joke`';
    $query = $pdo->prepare($sql);
    $query->execute();
    return $query->fetch()[0];
}
