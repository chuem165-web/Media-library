<?php

namespace App\DTO;

class ApiResponseDTO
{
    public function __construct(

        public bool $success,

        public string $message,

        public mixed $data = null,

        public array $errors = []
    ) {}

    public function toArray(): array
    {
        return [

            'success' => $this->success,

            'message' => $this->message,

            'data' => $this->data,

            'errors' => $this->errors
        ];
    }
}