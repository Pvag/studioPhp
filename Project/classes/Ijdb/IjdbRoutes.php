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

use Ninja\DatabaseTable; // ***

class IjdbRoutes implements \Ninja\Routes
{
    // TODO how to handle wrong actions? Who is handling those? The calling env.?
    public function getRoutes()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $jokesTable = new DatabaseTable($pdo, 'joke', 'id'); // *** no need to specify \Ninja
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');
        $jokeController = new Controllers\Joke($jokesTable, $authorsTable); // Controller is a sub-namespace to Ijdb
        $authorController = new Controllers\Register($authorsTable);
        $routes = [
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ]
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
                ]
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
            ]
        ];
        return $routes;
    }
}
