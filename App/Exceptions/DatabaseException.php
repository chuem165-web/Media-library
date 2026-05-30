<?php

namespace App\Exceptions;

class DatabaseException extends BaseException
{
    public function __construct(string $message = "Database error")
    {
        parent::__construct($message, 500);
    }
}