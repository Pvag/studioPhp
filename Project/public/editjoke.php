<?php

try {
    include __DIR__ . '/../includes/DatabaseFunctions.php';
    include __DIR__ . '/../includes/DatabaseConnection.php';
    if (isset($_POST['joketext'])) {
        $authorID = 1; // TODO hard coded, for now
        update($pdo, 'joke', 'id', [
            'id' => $_POST['id'],
            'joketext' => $_POST['joketext'],
            'authorid' => $authorID
        ]);

        header('location: jokes.php');
    } else {
        $title = 'Edit the joke';
        $id = $_GET['id'];
        $joketext = getJoke($pdo, $id)['joketext'];
        ob_start();
        include __DIR__ . '/../templates/editjoke.html.php';
        $output = ob_get_clean();
    }
} catch (PDOException $e) {
    $title = 'error in edit joke';
    $output = 'Sorry, unable to get jokes! ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
