<?php

$title = 'Jokes List';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb;charset=utf8', 'pvag', 'asDeup');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT `id`, `joketext` FROM `ijdb`.`joke`';
    $result = $pdo->query($sql);

    ob_start();
    include __DIR__ . '/../templates/jokes.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $output = 'Sorry, unable to get jokes! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
