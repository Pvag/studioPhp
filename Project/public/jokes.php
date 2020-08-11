<?php

$title = 'Jokes List';

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    //// same result in $jokes
    ////
    // $jokes = allJokes($pdo); // 1 db access
    ////
    // N+1 db accesses (N = number of jokes in db)
    $jokesOnly = findAll($pdo, 'joke'); // 1 db access
    foreach ($jokesOnly as $joke) {
        $author = findById($pdo, 'author', 'id', $joke['authorid']); // N db accesses
        $jokeComplete =
            [
                'id' => $joke['id'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name' => $author['name'],
                'email' => $author['email']
            ];
        $jokes[] = $jokeComplete;
    }

    $jokesCount = total($pdo, 'joke');
    ob_start();
    include __DIR__ . '/../templates/jokes.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $output = 'Sorry, unable to get jokes! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
