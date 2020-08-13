<?php

include __DIR__ . '/../includes/DatabaseConnection.php'; // creates the PDO
include __DIR__ . '/../controllers/JokeController.php';
include __DIR__ . '/../classes/DatabaseTable.php';

// avoids variable name clashes with local environment
// after 'extraction' from "values['variables']"
// (scope is limited to function level)
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
    $action = $_GET['action'] ?? 'home'; // if index is called with no action or no valid action, home is loaded
    $values = $jokeController->$action();
    $output = loadTemplate($values);
} catch (PDOException $e) {
    $output = 'Sorry! ' . $e->getMessage();
}

$title = $values['title'] ?? 'Error';

include __DIR__ . '/../templates/layout.html.php';
