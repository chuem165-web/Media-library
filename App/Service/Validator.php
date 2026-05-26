<?php

namespace App\Service;

class Validator
{   
    
    private array $errors = [];

    public function validate(
        array $data,
        array $rules
    ): bool {

        foreach (
            $rules as $field => $ruleSet
        ) {

            $value =
                trim(
                    $data[$field]
                    ?? ''
                );

            // required

            if (
                ($ruleSet['required']
                ?? false)

                && empty($value)
            ) {

                $this->errors[$field][] =
                    ucfirst($field)
                    . ' is required';

                continue;
            }

            // min length

            if (
                isset(
                    $ruleSet['min']
                )

                && strlen($value)
                < $ruleSet['min']
            ) {

                $this->errors[$field][] =
                    ucfirst($field)
                    . ' must be at least '
                    . $ruleSet['min']
                    . ' characters';
            }

            // max length

            if (
                isset(
                    $ruleSet['max']
                )

                && strlen($value)
                > $ruleSet['max']
            ) {

                $this->errors[$field][] =
                    ucfirst($field)
                    . ' too long';
            }

            // email

            if (
                !empty(
                    $ruleSet['email']
                )

                &&
                !filter_var(
                    $value,
                    FILTER_VALIDATE_EMAIL
                )
            ) {

                $this->errors[$field][] =
                    'Invalid email';
            }
        }

        return empty(
            $this->errors
        );
    }

    public function errors(): array
    {
        return $this->errors;
    }
}