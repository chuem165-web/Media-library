<?php

namespace App\Http\Request;

use App\Validation\Validator;

abstract class FormRequest
{
    protected array $data;

    protected array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    abstract public function rules(): array;

    public function validate(): bool
    {
        $validator = new Validator();

        $this->errors = $validator->validate(
            $this->data,
            $this->rules()
        );

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function input(
        string $key
    ): mixed {

        return trim(
            $this->data[$key] ?? ''
        );
    }
}