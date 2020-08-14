<?php
class EntryPoint
{
    private $route;
    public function __construct($route)
    {
        $this->route = $route;
        $this->checkUrl();
    }

    private function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) {
            $this->route = strtolower($this->route);
            http_response_code(301);
            header('location: /' . $this->route);
        }
    }

    // avoids variable name clashes with local environment
    // after 'extraction' from "values['variables']"
    // (scope is limited to function level)
    private function loadTemplate($values)
    {
        $template = $values['template'];
        extract($values['variables']);
        ob_start();
        include __DIR__ . '/../templates/' . $template . '.html.php'; // values for the specific template are extracted from $values['variables']
        return ob_get_clean();
    }

    public function run()
    {
        $values = $this->callAction();
        $title = $values['title'] ?? 'Error';
        $output = $this->loadTemplate($values);
        include __DIR__ . '/../templates/layout.html.php';
    }

    private function callAction()
    {
        include __DIR__ . '/../includes/DatabaseConnection.php'; // creates the PDO
        include __DIR__ . '/../classes/DatabaseTable.php';
        include __DIR__ . '/../controllers/JokeController.php';
        include __DIR__ . '/../controllers/RegisterController.php';

        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');

        // * parameters injection *
        //     solving the dependency problem (different controllers require different parameters)
        //     using multiple if / else clauses : redundant but safe
        // (a Service Locator would be more succinct, but is considered bad practice)

        if ($this->route === 'joke/list') {
            $jokeController = new JokeController($jokesTable, $authorsTable);
            $values = $jokeController->list();
        } else if ($this->route === 'joke/home') {
            $jokeController = new JokeController($jokesTable, $authorsTable);
            $values = $jokeController->home();
        } else if ($this->route === 'joke/edit') {
            $jokeController = new JokeController($jokesTable, $authorsTable);
            $values = $jokeController->edit();
        } else if ($this->route === 'joke/delete') {
            $jokeController = new JokeController($jokesTable, $authorsTable);
            $jokeController->delete();
        } else if ($this->route === 'author/edit') {
            $authorController = new RegisterController($authorsTable);
            // TODO
        } else {
            // route home
            $route = 'joke/home';
            header('location: /' . $route);
        }
        return $values;
    }
}
