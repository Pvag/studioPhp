<?php

namespace Ijdb\Controllers;

class Register
{
    private $authorsTable;

    public function __construct(\Ninja\DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }
}
