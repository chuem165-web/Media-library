<?php

namespace App\DTO;

class LoginDTO
{
    // CHANGED: made properties private (encapsulation)
    private string $email;
    private string $password;

    public function __construct(
        string $email,
        string $password
    ) {
        // CHANGED: assign constructor values properly
        $this->email = $email;
        $this->password = $password;
    }

    // CHANGED: added getter because private properties cannot be accessed directly
    public function getEmail(): string
    {
        return $this->email;
    }

    // CHANGED: added getter for password
    public function getPassword(): string
    {
        return $this->password;
    }
}