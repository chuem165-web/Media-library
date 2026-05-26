<?php

class SuggestService extends BaseService
{
    /**
     * Validate and sanitize input only
     */
    public function process(array $input): array
    {
        $data = [
            'name' =>
                trim($input['name'] ?? ''),

            'email' =>
                trim($input['email'] ?? ''),

            'category' =>
                trim($input['category'] ?? ''),

            'title' =>
                trim($input['title'] ?? ''),

            'format' =>
                trim($input['format'] ?? ''),

            'genre' =>
                trim($input['genre'] ?? ''),

            'year' =>
                trim($input['year'] ?? ''),

            'details' =>
                trim($input['details'] ?? ''),

            'error_message' => null
        ];

        return $this->validate($data, $input);
    }

    /**
     * Validation rules only (SRP)
     */
    private function validate(array $data, array $input): array
    {
        // required fields
        if (
            empty($data['name']) ||
            empty($data['email']) ||
            empty($data['category']) ||
            empty($data['title'])
        ) {
            $data['error_message'] =
                'Please fill required fields';

            return $data;
        }

        // honeypot
        if (!empty($input['address'] ?? null)) {
            $data['error_message'] =
                'Bad form input';

            return $data;
        }

        // email validation
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['error_message'] =
                'Invalid email';

            return $data;
        }

        return $data;
    }
}