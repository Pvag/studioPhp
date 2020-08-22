<?php

namespace Ijdb\Entity;

class Joke
{
    public $id;
    public $joketext;
    public $jokedate;
    public $authorid;
    private $authorsTable;
    private $author;    // transparent caching!

    public function __construct(\Ninja\DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }

    public function getAuthor()
    {
        if (empty($this->author)) {
            $this->author = $this->authorsTable->findById($this->authorid);
        }
        return $this->author;
    }
}
