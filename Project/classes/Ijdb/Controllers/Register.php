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
        $valid = true;
        $author = $_POST['author'];
        $author['id'] = '';
        // $error

        if (empty($author['name'])) {
            $valid = false;
        }
        if (empty($author['email'])) {
            $valid = false;
        }
        if (empty($author['password'])) {
            $valid = false;
        }
        if ($valid) {
            $this->authorsTable->save($author);
            header('location: /author/success');
        } else {
            header('location: /author/register');
        }
    }
}
