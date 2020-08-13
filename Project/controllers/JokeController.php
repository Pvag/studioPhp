<?php

// This is a "controller" class, so I save it in the 'controller' directory;
// methods inside a "controller" class are called  * actions *.
class JokeController
{
    private $jokesTable;
    private $authorsTable;

    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
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
                'jokes' => $jokes
            ]
        ];
        return $values;
    }

    public function delete()
    {
        $this->jokesTable->delete($_POST['id']);
        header('location: jokes.php');
    }

    public function edit()
    {
        if (isset($_POST['joke'])) {
            $authorID = 1; // TODO hard coded, for now
            $joke = $_POST['joke'];
            $joke['authorid'] = $authorID;
            $joke['jokedate'] = new DateTime();
            // $joke has the id key: save will determine whether this save must be an update (id already existing in db) or an insert (no value provided for id)
            $this->jokesTable->save($joke);
            header('location: index.php?action=list');
        } else {
            $id = $_GET['id'] ?? ''; // is '' if user is in 'Add Joke' page
            $joketext = $this->jokesTable->findById($id)['joketext']; // is 'null' if user is in 'Add Joke' page
            $values = [
                'title' => $id ? 'Edit joke' : 'Add joke',
                'template' => 'editjoke',
                'variables' => [
                    'id' => $id,
                    'joketext' => $joketext
                ]
            ];
            return $values;
        }
    }
}
