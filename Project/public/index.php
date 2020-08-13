<?php

include __DIR__ . '/../includes/DatabaseConnection.php'; // creates the PDO
include __DIR__ . '/../controllers/JokeController.php';
include __DIR__ . '/../classes/DatabaseTable.php';

function loadTemplate($values)
{
    $template = $values['template'];
    extract($values['variables']);
    ob_start();
    include __DIR__ . '/../templates/' . $template . '.html.php'; // values for the specific template are extracted from $values['variables']
    return ob_get_clean();
}

$jokesTable = new DatabaseTable($pdo, 'joke', 'id');
$authorsTable = new DatabaseTable($pdo, 'author', 'id');
$jokeController = new JokeController($jokesTable, $authorsTable);

try {
    $action = $_GET['action'] ?? '';
    if ($action == 'list') {
        $values = $jokeController->list();
    } else if ($action == 'delete') {
        $values = $jokeController->delete($_POST['id']);
    } else if ($action == 'edit') {
        $id = $_GET['id'] ?? '';
        $values = $jokeController->edit($id);
    } else {
        $values = $jokeController->home();
    }
    $output = loadTemplate($values);
} catch (PDOException $e) {
    $output = 'Sorry! ' . $e->getMessage();
}

$title = $values['title'] ?? 'Error';

include __DIR__ . '/../templates/layout.html.php';
