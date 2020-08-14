<?php
class RegisterController
{
    private $authorsTable;

    public function __construct(DatabaseTable $authorsTable)
    {
        $this->authorsTable = $authorsTable;
    }
}
