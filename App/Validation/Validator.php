<?php

namespace App\Validation;

class Validator
{
    public function validate(array $data, array $rules): array
{
    $errors = [];

    foreach ($rules as $field => $ruleSet) {

        $value = trim($data[$field] ?? '');

        // REQUIRED FIRST
        if (($ruleSet['required'] ?? false) && $value === '') {
            $errors[$field][] = "{$field} is required";
            continue;
        }

        // MIN
        if (isset($ruleSet['min']) && strlen($value) < $ruleSet['min']) {
            $errors[$field][] = "{$field} minimum {$ruleSet['min']} characters";
        }

        // MAX
        if (isset($ruleSet['max']) && strlen($value) > $ruleSet['max']) {
            $errors[$field][] = "{$field} maximum {$ruleSet['max']} characters";
        }

        // EMAIL
        if (($ruleSet['email'] ?? false) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[$field][] = "Invalid email";
        }
    }

    return $errors;
}
}