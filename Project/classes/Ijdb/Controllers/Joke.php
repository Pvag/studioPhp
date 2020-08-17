<?php

namespace Ijdb\Controllers;

// This is a "controller" class, so I save it in the 'controller' directory;
// methods inside a "controller" class are called  * actions *.
class Joke
{
    private $jokesTable;
    private $authorsTable;
    private $authentication;

    public function __construct(\Ninja\DatabaseTable $jokesTable, \Ninja\DatabaseTable $authorsTable, \Ninja\Authentication $authentication)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
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
        //// same result in $jokes
        ////
        // $jokes = allJokes($pdo); // 1 db access
        ////
        // N+1 db accesses (N = number of jokes in db)
        $jokesOnly = $this->jokesTable->findAll(); // 1 db access
        foreach ($jokesOnly as $joke) {
            $author = $this->authorsTable->findById($joke['authorid']); // N db accesses // TODO FIX AUTHOR TABLE!!
            $joke['name'] = $author['name'];
            $joke['email'] = $author['email'];
            $jokes[] = $joke;
        }

        $jokesCount = $this->jokesTable->total();
        $values = [
            'title' => 'Joke List',
            'template' => 'jokes',
            'variables' => [
                'jokesCount' => $jokesCount,
                'jokes' => $jokes,
                'userid' => $this->authentication->getUser()['id'] ?? null
            ]
        ];
        return $values;
    }

    public function delete()
    {
        $authorId = $this->jokesTable->findById($_POST['id'])['authorid'];
        $userId = $this->authentication->getUser()['id'];
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
        $values = [
            'title' => $id ? 'Edit joke' : 'Add joke',
            'template' => 'editjoke',
            'variables' => [
                'id' => $id,
                'joketext' => $joke['joketext'],
                'authorid' => $joke['authorid'] ?? null,
                'userid' => $this->authentication->getUser()['id'] ?? null
            ]
        ];
        return $values;
    }

    public function saveEdit()
    {
        $joke = $_POST['joke'];
        $user = $this->authentication->getUser();
        // case of insertion of new joke
        if ($_POST['joke']['id'] == '') {
            $joke['authorid'] = $user['id'];
            $joke['jokedate'] = new \DateTime();
            $this->jokesTable->save($joke);
            header('location: /joke/list');
        } else {
            $oldPost = $this->jokesTable->findById($_POST['joke']['id']);
            // case of edit of existing joke
            if ($user['id'] == $oldPost['authorid']) {
                $joke['authorid'] = $user['id'];
                $joke['jokedate'] = new \DateTime();
                $this->jokesTable->save($joke); // case of authorized edit
                header('location: /joke/list');
            } else {
                return;
                // return [
                //     'title' => 'w',
                //     'template' => 'test',
                //     [
                //         'joketext' => $joke['joketext'],
                //         'authorid' => $joke['authorid'] ?? null,
                //         'userid' => $this->authentication->getUser()['id'] ?? null
                //     ]
                // ]; // case of unauthorized edit
            }
        }
    }
}
