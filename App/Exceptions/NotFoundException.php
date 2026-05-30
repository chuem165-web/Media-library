<?php

namespace App\Exceptions;

class NotFoundException extends BaseException
{
    public function __construct(string $message = "Resource not found")
    {
        parent::__construct($message, 404);
    }
}