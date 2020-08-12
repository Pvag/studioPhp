<?php

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';

    $jokeTable = new DatabaseTable($pdo, 'joke', 'id');
    if (isset($_POST['joke'])) {
        $authorID = 1; // TODO hard coded, for now
        // save is generic, it would still work on table 'book', with pk 'isbn';
        // furthermore it chooses whether to perform an 'update' or an 'insert'
        $joke = $_POST['joke'];
        $joke['authorid'] = $authorID;
        $joke['jokedate'] = new DateTime();
        $jokeTable->save($joke);

        header('location: jokes.php');
    } else {
        $title = 'Text of the joke';
        $id = $_GET['id'] ?? ''; // is '' if user is in 'Add Joke' page
        $joketext = $jokeTable->findById($id)['joketext']; // is 'null' if user is in 'Add Joke' page
        ob_start();
        include __DIR__ . '/../templates/editjoke.html.php';
        $output = ob_get_clean();
    }
} catch (PDOException $e) {
    $title = 'error in edit joke';
    $output = 'Sorry, unable to get jokes! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
