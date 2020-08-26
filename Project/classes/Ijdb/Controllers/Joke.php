<?php

namespace Ijdb\Controllers;

// This is a "controller" class, so I save it in the 'controller' directory;
// methods inside a "controller" class are called  * actions *.
class Joke
{
    private $jokesTable;
    private $authorsTable;
    private $categoriesTable;
    private $authentication;

    public function __construct(\Ninja\DatabaseTable $jokesTable, \Ninja\DatabaseTable $authorsTable, \Ninja\DatabaseTable $categoriesTable, \Ninja\Authentication $authentication)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->categoriesTable = $categoriesTable;
        $this->authentication = $authentication;
    }

    public function home()
    {
        $values = [
            'title' => 'Home',
            'template' => 'home',
            'variables' => []
        ];
        return $values;
    }

    public function list()
    {
        if (isset($_GET['category'])) {
            $category = $this->categoriesTable->findById($_GET['category']); // --> \Entity\Category
            $jokes = $category->getJokes();
        } else {
            $jokes = $this->jokesTable->findAll();
        }
        $jokesCount = $this->jokesTable->total();
        $values = [
            'title' => 'Joke List',
            'template' => 'jokes',
            'variables' => [
                'jokesCount' => $jokesCount,
                'jokes' => $jokes,
                'userid' => $this->authentication->getUser()->id ?? null,
                'categories' => $this->categoriesTable->findAll()
            ]
        ];
        return $values;
    }

    public function delete()
    {
        $authorId = $this->jokesTable->findById($_POST['id'])->authorid;
        $userId = $this->authentication->getUser()->id;
        if ($userId == $authorId) {
            $this->jokesTable->delete($_POST['id']);
            header('location: /joke/list');
        } else {
            return;
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? ''; // is '' if user is in 'Add Joke' page
        $joke = $this->jokesTable->findById($id); // is 'null' if user is in 'Add Joke' page
        $categories = $this->categoriesTable->findAll();
        $values = [
            'title' => $id ? 'Edit joke' : 'Add joke',
            'template' => 'editjoke',
            'variables' => [
                'id' => $id,
                'joketext' => $joke->joketext ?? null,
                'authorid' => $joke->authorid ?? null,
                'userid' => $this->authentication->getUser()->id ?? null,
                'categories' => $categories // TODO add already selected categories
            ]
        ];
        return $values;
    }

    public function saveEdit()
    {
        $joke = $_POST['joke'];
        $user = $this->authentication->getUser();

        // case of insertion of new joke
        $oldPost = $this->jokesTable->findById($joke['id']);
        if ($joke['id'] == '' || $user->id == $oldPost->authorid) {
            $joke['jokedate'] = new \DateTime();
            $entity = $user->addJoke($joke);
            $categories = $_POST['category'];
            foreach ($categories as $category) {
                $entity->addCategory($category);
            }
            header('location: /joke/list');
        } else {
            return; // case of unauthorized edit
        }
    }
}
