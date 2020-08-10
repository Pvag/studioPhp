<?php
if (isset($_POST['id'])) {
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../includes/DatabaseFunctions.php';

        deleteJoke($pdo, $_POST['id']);

        header('location: jokes.php');
    } catch (PDOException $e) {
        $title = 'Error deleting joke! ' . $e->getMessage();
    }
} else {
    header('location: index.php');
}

include __DIR__ . '/../templates/layout.html.php';
