<?php

$title = 'Jokes List';

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email`
                FROM `ijdb`.`joke` INNER JOIN `ijdb`.`author` ON `joke`.`authorid` = `author`.`id`';
    $result = $pdo->query($sql);

    $jokesCount = totalJokes($pdo); // used inside jokes.html.php
    ob_start();
    include __DIR__ . '/../templates/jokes.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $output = 'Sorry, unable to get jokes! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
