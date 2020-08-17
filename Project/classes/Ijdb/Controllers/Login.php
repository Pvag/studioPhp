<?php

namespace Ijdb\Controllers;

class Login
{
    public function __construct()
    {
    }

    public function loginError()
    {
        return [
            'title' => 'Login Error',
            'template' => 'loginerror',
            'variables' => []
        ];
    }
}
