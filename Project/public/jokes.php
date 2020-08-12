<?php

$title = 'Jokes List';

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';

    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
    $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    //// same result in $jokes
    ////
    // $jokes = allJokes($pdo); // 1 db access
    ////
    // N+1 db accesses (N = number of jokes in db)
    $jokesOnly = $jokesTable->findAll(); // 1 db access
    foreach ($jokesOnly as $joke) {
        $author = $authorsTable->findById($joke['authorid']); // N db accesses // TODO FIX AUTHOR TABLE!!
        $joke['name'] = $author['name'];
        $joke['email'] = $author['email'];
        $jokes[] = $joke;
    }

    $jokesCount = $jokesTable->total();
    ob_start();
    include __DIR__ . '/../templates/jokes.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $output = 'Sorry, unable to get jokes! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
