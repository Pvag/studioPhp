<?php

namespace Ijdb\Entity;

class Joke
{
    public $id;
    public $joketext;
    public $jokedate;
    public $authorid;
    private $authorsTable;

    public function __construct(\Ninja\DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }

    public function getAuthor()
    {
        return $this->authorsTable->findById($this->authorid);
    }
}
