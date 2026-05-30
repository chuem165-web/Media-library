<?php

namespace App\Exceptions;

use Exception;

abstract class BaseException extends Exception
{
    protected int $statusCode = 500;
    protected array $errors = [];

    public function __construct(
        string $message = "",
        int $statusCode = 500,
        array $errors = []
    ) {
        parent::__construct($message, $statusCode);
        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function toArray(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
            'errors'  => $this->errors,
            'code'    => $this->statusCode,
        ];
    }
}