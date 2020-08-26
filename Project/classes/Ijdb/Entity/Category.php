<?php

namespace Ijdb\Entity;

class Category
{
    // these 2 properties are automatically set by PDO->fetch() called in 'findById'
    public $id; // first column of 'category' table
    public $name; // second column of 'category' table

    private $jokesTable;
    private $jokesCategoriesTable;

    public function __construct(\Ninja\DatabaseTable $jokesTable, \Ninja\DatabaseTable $jokesCategoriesTable)
    {
        $this->jokesTable = $jokesTable;
        $this->jokesCategoriesTable = $jokesCategoriesTable;
    }

    public function getJokes()
    {
        // $this->id will be the value set to the PK for the research in the 'jokesCategories' table;
        // that table's primary key is 'categoryId'
        // i.e. 'categoryId' is the column name in table 'joke_category'
        // corresponding to 'id' in table 'category'
        $jokesCategory = $this->jokesCategoriesTable->find('categoryId', $this->id); // --> stdClass with properties 'jokeId' and 'categoryId'
        foreach ($jokesCategory as $jokeCategory) {
            $joke = $this->jokesTable->findById($jokeCategory->jokeId);
            if ($joke) {
                $jokes[] = $joke;
            }
        }
        return $jokes;
    }
}
