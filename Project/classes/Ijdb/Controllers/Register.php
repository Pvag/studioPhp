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
        $errors = [];

        if (empty($author['name'])) {
            $valid = false;
            $errors[] = 'No <b>name</b> provided!';
        }
        if (empty($author['email'])) {
            $valid = false;
            $errors[] = 'No <b>email</b> provided!';
        }
        if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
            $valid = false;
            $errors[] = '<b>Email</b> is not valid!';
        } else {
            $author['email'] = strtolower($author['email']);
            if (count($this->authorsTable->find('email', $author['email'])) > 0) {
                $valid = false;
                $errors[] = 'Email <b>already existing</b>!';
            }
        }
        if (empty($author['password'])) {
            $valid = false;
            $errors[] = 'No <b>password</b> provided!';
        }
        if ($valid) {
            // encrypt password
            $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
            $this->authorsTable->save($author);
            header('location: /author/success');
        } else {
            return [
                'title' => 'Errors in Form!',
                'template' => 'register',
                'variables' => [
                    'errors' => $errors,
                    'author' => $author
                ]
            ];
        }
    }
}
