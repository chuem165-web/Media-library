<?php

namespace App\Exceptions;

use App\Exceptions\BaseException;

class CatalogNotFoundException extends BaseException
{
    public function __construct(
        string $message = "Catalog item not found"
    ) {
        parent::__construct($message, 404);
    }
}