<?php

namespace Ijdb\Entity;

class Joke
{
    public $id;
    public $joketext;
    public $jokedate;
    public $authorid;
    private $authorsTable;
    private $jokesCategoriesTable;
    private $author;    // transparent caching!

    public function __construct(\Ninja\DatabaseTable $authorsTable, \Ninja\DatabaseTable $jokesCategoriesTable)
    {
        $this->authorsTable = $authorsTable;
        $this->jokesCategoriesTable = $jokesCategoriesTable;
    }

    public function getAuthor()
    {
        if (empty($this->author)) {
            $this->author = $this->authorsTable->findById($this->authorid);
        }
        return $this->author;
    }

    public function addCategory($category)
    {
        $this->jokesCategoriesTable->insert([
            'jokeId' => $this->id,
            'categoryId' => $category
        ]);
    }
}
