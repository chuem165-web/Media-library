<?php

namespace App\Service;

abstract class BaseService
{
    protected function env(
        string $key,
        ?string $default = null
    ): ?string {

        $value =
            $_ENV[$key]
            ?? getenv($key);

        return
            $value !== false
            && $value !== null
            ? $value
            : $default;
    }

    protected function db(): \PDO
    {
        return \Database::getConnection();
    }
}