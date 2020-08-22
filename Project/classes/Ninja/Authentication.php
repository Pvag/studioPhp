<?php

namespace Ninja;

class Authentication
{
    private $authorsTable;
    private $usernameColumn;
    private $passwordColumn;

    public function __construct(DatabaseTable $authorsTable, $usernameColumn, $passwordColumn)
    {
        session_start();
        $this->authorsTable = $authorsTable;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }

    public function login($username, $password)
    {
        $users = $this->authorsTable->find($this->usernameColumn, strtolower($username));
        if (!empty($users) && password_verify($password, $users[0]->{$this->passwordColumn})) {
            session_regenerate_id();
            $_SESSION['username'] = strtolower($username);
            $_SESSION['password'] = $users[0]->{$this->passwordColumn};
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedIn()
    {
        if (!isset($_SESSION['username'])) {
            return false;
        }
        $users = $this->authorsTable->find($this->usernameColumn, $_SESSION['username']);
        if (!empty($users) && ($_SESSION['password'] === $users[0]->{$this->passwordColumn})) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->isLoggedIn()) {
            return $this->authorsTable->find($this->usernameColumn, $_SESSION['username'])[0];
        } else return false;
    }
}
