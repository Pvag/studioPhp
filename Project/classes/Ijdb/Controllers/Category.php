<?php

namespace Ijdb\Controllers;

class Category
{
    private $categoriesTable;

    public function __construct(\Ninja\DatabaseTable $categoriesTable)
    {
        $this->categoriesTable = $categoriesTable;
    }

    public function edit()
    {
        if (isset($_GET['category']['id'])) {
            $category = $this->categoriesTable->findById($_GET['category']['id']);
        }
        $title = 'Edit Category';
        return [
            'title' => $title,
            'template' => 'editcategory',
            'variables' => [
                'category' => $category ?? null
            ]
        ];
    }

    public function saveEdit()
    {
        $this->categoriesTable->save($_POST['category']);
        header('location: /category/list');
    }

    public function delete()
    {
        $this->categoriesTable->delete($_POST['category']['id']);
        header('location: /category/list');
    }

    public function list()
    {
        $categories = $this->categoriesTable->findAll();
        return [
            'title' => 'Joke Categories',
            'template' => 'categories',
            'variables' => [
                'categories' => $categories
            ]
        ];
    }
}
