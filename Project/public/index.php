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

try {
    // controller/action
    $route = ltrim((strtok($_SERVER['REQUEST_URI'], '?')), '/') ?? 'joke/home';
    if ($route !== strtolower($route)) {
        http_response_code(301); // permanent redirect
        header('location: ' . strtolower($route));
    }
    // * parameters injection *
    //     solving the dependency problem (different controllers require different parameters)
    //     using multiple if / else clauses : redundant but safe
    // (a Service Locator would be more succinct, but is considered bad practice)
    if ($route === 'joke/list') {
        $jokeController = new JokeController($jokesTable, $authorsTable);
        $values = $jokeController->list();
    } else if ($route === 'joke/home') {
        $jokeController = new JokeController($jokesTable, $authorsTable);
        $values = $jokeController->home();
    } else if ($route === 'joke/edit') {
        $jokeController = new JokeController($jokesTable, $authorsTable);
        $values = $jokeController->edit();
    } else if ($route === 'joke/delete') {
        $jokeController = new JokeController($jokesTable, $authorsTable);
        $jokeController->delete();
    } else if ($route === 'author/edit') {
        $authorController = new RegisterController($authorsTable);
        // TODO
    } else {
        // route home
        $route = 'joke/home';
        header('location: /' . $route);
    }
    $output = loadTemplate($values);
} catch (PDOException $e) {
    $output = 'Sorry! ' . $e->getMessage();
}

$title = $values['title'] ?? 'Error';

include __DIR__ . '/../templates/layout.html.php';
