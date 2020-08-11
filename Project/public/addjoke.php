<?php
$title = 'Add Joke';
if (isset($_POST['joketext'])) {
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../includes/DatabaseFunctions.php';

        $authorid = '1'; // fixed, for now
        insert($pdo, 'joke', [
            'joketext' => $_POST['joketext'],
            'authorid' => $authorid,
            'jokedate' => new DateTime()
        ]);

        header('location: jokes.php');
    } catch (PDOException $e) {
        $output = 'Problems accessing db in \'Add Joke\'. ' . $e->getMessage();
    }
} else {
    ob_start();
    include __DIR__ . '/../templates/addjoke.html.php';
    $output = ob_get_clean();
}

include __DIR__ . '/../templates/layout.html.php';
