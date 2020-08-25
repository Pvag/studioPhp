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
use Ninja\DatabaseTable;

class IjdbRoutes implements \Ninja\Routes
{
    private $jokesTable;
    private $authorsTable;
    private $categoriesTable;
    private $authentication;

    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $this->jokesTable = new DatabaseTable($pdo, 'joke', 'id', '\Ijdb\Entity\Joke', [&$this->authorsTable, &$this->jokesCategoriesTable]);
        $this->authorsTable = new DatabaseTable($pdo, 'author', 'id', '\Ijdb\Entity\Author', [&$this->jokesTable]);
        $this->categoriesTable = new DatabaseTable($pdo, 'category', 'id');
        $this->jokesCategoriesTable = new DatabaseTable($pdo, 'joke_category', 'categoryId');
        $this->authentication = new Authentication($this->authorsTable, 'email', 'password');
    }

    // TODO how to handle wrong actions? Who is handling those? The calling env.?
    public function getRoutes(): array
    {
        $jokeController = new Controllers\Joke($this->jokesTable, $this->authorsTable, $this->categoriesTable, $this->authentication);
        $authorController = new Controllers\Register($this->authorsTable);
        $categoryController = new Controllers\Category($this->categoriesTable);
        $loginController = new Controllers\Login($this->authentication);
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
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'success'
                ],
                'login' => true // !!!
            ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'logout'
                ]
            ],
            'category/edit' => [
                'GET' => [
                    'controller' => $categoryController,
                    'action' => 'edit'
                ],
                'POST' => [
                    'controller' => $categoryController,
                    'action' => 'saveEdit'
                ],
                'login' => true
            ],
            'category/list' => [
                'GET' => [
                    'controller' => $categoryController,
                    'action' => 'list'
                ],
                'login' => true
            ],
            'category/delete' => [
                'POST' => [
                    'controller' => $categoryController,
                    'action' => 'delete'
                ],
                'login' => true
            ]
        ];
        return $routes;
    }

    public function getAuthentication(): \Ninja\Authentication
    {
        return $this->authentication;
    }
}
