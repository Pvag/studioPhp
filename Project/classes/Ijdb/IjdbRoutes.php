<?php
// This class contains actions (routes) specific to
// the Internet Joke Database app.
// For a different app, I would provide a different
// 'xxyyRoutes.php' and inject its instance inside EntryPoint;
// EntryPoint.php would remain unaltered, though.
// So EntryPoint.php is a framework class (independent
// of the specific project (and therefore 'Route') at hand).

namespace Ijdb;

class IjdbRoutes
{
    public function __construct()
    {
    }

    public function callAction($route)
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php'; // creates the PDO

        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');

        // * parameters injection *
        //     solving the dependency problem (different controllers require different parameters)
        //     using multiple if / else clauses : redundant but safe
        // (a Service Locator would be more succinct, but is considered bad practice)

        if ($route === 'joke/list') {
            $jokeController = new Controllers\Joke($jokesTable, $authorsTable);
            $values = $jokeController->list();
        } else if ($route === 'joke/home') {
            $jokeController = new Controllers\Joke($jokesTable, $authorsTable);
            $values = $jokeController->home();
        } else if ($route === 'joke/edit') {
            $jokeController = new Controllers\Joke($jokesTable, $authorsTable);
            $values = $jokeController->edit();
        } else if ($route === 'joke/delete') {
            $jokeController = new Controllers\Joke($jokesTable, $authorsTable);
            $jokeController->delete();
        } else if ($route === 'author/edit') {
            $authorController = new Controllers\Register($authorsTable);
            // TODO
        } else {
            // route home
            $route = 'joke/home';
            header('location: /' . $route);
        }
        return $values;
    }
}
