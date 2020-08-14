<?php
// This class contains actions (routes) specific to
// the Internet Joke Database app.
// For a different app, I would provide a different
// 'xxyyActions.php' and inject it inside EntryPoint;
// EntryPoint.php would remain unaltered, though.
// So EntryPoint.php is a framework class (independent
// of the specific project at hand).
class IjdbActions
{
    public function __construct()
    {
    }

    public function callAction($route)
    {
        include __DIR__ . '/../includes/DatabaseConnection.php'; // creates the PDO
        include __DIR__ . '/../classes/DatabaseTable.php';
        include __DIR__ . '/../classes/controllers/Joke.php';
        include __DIR__ . '/../classes/controllers/Register.php';

        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');

        // * parameters injection *
        //     solving the dependency problem (different controllers require different parameters)
        //     using multiple if / else clauses : redundant but safe
        // (a Service Locator would be more succinct, but is considered bad practice)

        if ($route === 'joke/list') {
            $jokeController = new Joke($jokesTable, $authorsTable);
            $values = $jokeController->list();
        } else if ($route === 'joke/home') {
            $jokeController = new Joke($jokesTable, $authorsTable);
            $values = $jokeController->home();
        } else if ($route === 'joke/edit') {
            $jokeController = new Joke($jokesTable, $authorsTable);
            $values = $jokeController->edit();
        } else if ($route === 'joke/delete') {
            $jokeController = new Joke($jokesTable, $authorsTable);
            $jokeController->delete();
        } else if ($route === 'author/edit') {
            $authorController = new Register($authorsTable);
            // TODO
        } else {
            // route home
            $route = 'joke/home';
            header('location: /' . $route);
        }
        return $values;
    }
}
