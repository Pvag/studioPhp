<?php

namespace Ijdb\Controllers;

class Register
{
    private $authorsTable;

    public function __construct(\Ninja\DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }

    public function registrationForm()
    {
        return [
            'template' => 'register',
            'title' => 'Register an Account',
            'variables' => []
        ];
    }

    public function success()
    {
        return [
            'template' => 'registersuccess',
            'title' => 'Registration Successful',
            'variables' => []
        ];
    }

    public function registerUser()
    {
        $author = $_POST['author'];
        $author['id'] = '';
        $this->authorsTable->save($author);
        header('location: /author/success');
    }
}
