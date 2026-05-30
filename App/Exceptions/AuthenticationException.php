<?php

namespace App\Exceptions;

class AuthenticationException extends BaseException
{
    public function __construct(string $message = "Unauthenticated")
    {
        parent::__construct($message, 401);
    }
}