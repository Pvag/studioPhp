<?php

namespace Ijdb\Controllers;

class Login
{
    private $authentication;

    public function __construct(\Ninja\Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function loginError()
    {
        return [
            'title' => 'Login Error',
            'template' => 'loginerror'
        ];
    }

    public function loginForm($errors = [])
    {
        return [
            'title' => 'Login Form',
            'template' => 'login',
            'variables' => $errors
        ];
    }

    public function processLogin()
    {
        if ($this->authentication->login($_POST['username'], $_POST['password'])) {
            header('location: /login/success');
        } else {
            $errors = ['error' => 'invalid e-mail/password'];
            return $this->loginForm($errors);
        }
    }

    public function success()
    {
        return [
            'title' => 'Login Successful',
            'template' => 'loginsuccess'
        ];
    }
}
