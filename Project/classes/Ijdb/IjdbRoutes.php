<?php
// This class contains actions (routes) specific to
// the Internet Joke Database app.
// For a different app, I would provide a different
// 'xxyyRoutes.php' and inject its instance inside EntryPoint;
// EntryPoint.php would remain unaltered, though.
// So EntryPoint.php is a framework class (independent
// of the specific project (and therefore 'Route') at hand).
// The interface '\Ninja\Routes' helps in the definition of
// the type of the parameters that the constructor for
// the 'EntryPoint' class expects.

namespace Ijdb;

use Ninja\Authentication;
use Ninja\DatabaseTable; // ***

class IjdbRoutes implements \Ninja\Routes
{
    private $jokesTable;
    private $authorsTable;
    private $authentication;

    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $this->jokesTable = new DatabaseTable($pdo, 'joke', 'id'); // *** no need to specify \Ninja
        $this->authorsTable = new DatabaseTable($pdo, 'author', 'id');
        $this->authentication = new Authentication($this->authorsTable, 'name', 'password');
    }

    // TODO how to handle wrong actions? Who is handling those? The calling env.?
    public function getRoutes(): array
    {
        $jokeController = new Controllers\Joke($this->jokesTable, $this->authorsTable); // Controller is a sub-namespace to Ijdb
        $authorController = new Controllers\Register($this->authorsTable);
        $loginController = new Controllers\Login();
        $routes = [
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ],
                'login' => true
            ],
            '' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home'
                ]
            ],
            'joke/home' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home'
                ]
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete'
                ],
                'login' => true
            ],
            'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'list'
                ]
            ],
            'author/register' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'registrationForm'
                ],
                'POST' => [
                    'controller' => $authorController,
                    'action' => 'registerUser'
                ]
            ],
            'author/success' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'success'
                ]
            ],
            'login/error' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginError'
                ]
            ]
        ];
        return $routes;
    }

    public function getAuthentication(): \Ninja\Authentication
    {
        return $this->authentication;
    }
}
