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

    public function addCategory($categoryId)
    {
        $this->jokesCategoriesTable->save([
            'jokeId' => $this->id,
            'categoryId' => $categoryId
        ]);
    }

    public function hasCategory($categoryId)
    {
        $jokeCategories = $this->jokesCategoriesTable->find('jokeId', $this->id);
        foreach ($jokeCategories as $jokeCategory) {
            if ($jokeCategory->categoryId == $categoryId) {
                return true;
            }
        }
        return false;
    }

    public function clearCategories()
    {
        $this->jokesCategoriesTable->deleteWhere('jokeId', $this->id);
    }
}
