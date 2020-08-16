<?php

namespace Ninja;

class Authentication
{
    private $userDb;
    private $usernameColumn;
    private $passwordColumn;

    public function __construct(DatabaseTable $userDb, $usernameColumn, $passwordColumn)
    {
        session_start();
        $this->userDb = $userDb;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }

    public function login($username, $password)
    {
        $users = $this->userDb->find($this->usernameColumn, strtolower($username));
        if (empty($users)) {
            return false;
        } else {
            if (password_verify($password, $users[0][$this->passwordColumn])) {
                session_regenerate_id();
                $_SESSION['username'] = strtolower($username);
                $_SESSION['password'] = $users[0][$this->passwordColumn];
                return true;
            }
        }
    }

    public function isLoggedIn()
    {
        if (!isset($_SESSION)) {
            return false;
        }
        $users = $this->userDb->find($this->usernameColumn, $_SESSION['username']);
        if (!empty($users) && ($_SESSION['password'] === $users[0][$this->passwordColumn])) {
            return true;
        } else {
            return false;
        }
    }
}
