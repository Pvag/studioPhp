<?php

try {
    include __DIR__ . '/../includes/DatabaseFunctions.php';
    include __DIR__ . '/../includes/DatabaseConnection.php';
    if (isset($_POST['joketext'])) {
        $authorID = 1; // TODO hard coded, for now
        // save is generic, it would still work on table 'book', with pk 'isbn';
        // furthermore it chooses whether to perform an 'update' or an 'insert'
        save($pdo, 'joke', 'id', [
            'id' => $_POST['id'], // is '' if user was in 'Add Joke'
            'joketext' => $_POST['joketext'],
            'authorid' => $authorID
        ]);
        // update($pdo, 'joke', 'id', [
        //     'id' => $_POST['id'],
        //     'joketext' => $_POST['joketext'],
        //     'authorid' => $authorID
        // ]);

        header('location: jokes.php');
    } else {
        $title = 'Text of the joke';
        $id = $_GET['id'] ?? ''; // is '' if user is in 'Add Joke' page
        $joketext = findById($pdo, 'joke', 'id', $id)['joketext']; // is '' if user is in 'Add Joke' page
        ob_start();
        include __DIR__ . '/../templates/editjoke.html.php';
        $output = ob_get_clean();
    }
} catch (PDOException $e) {
    $title = 'error in edit joke';
    $output = 'Sorry, unable to get jokes! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
