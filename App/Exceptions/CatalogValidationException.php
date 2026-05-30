<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class CatalogValidationException extends BaseException
{
    public function __construct(
        array $errors = []
    ) {
        parent::__construct(
            "Invalid catalog data",
            422,
            $errors
        );
    }
}