<?php

namespace App\Contract;

interface UserRepositoryInterface
{
    public function create(
        string $name,
        string $email,
        string $password
    ): bool;

    public function findByEmail(
        string $email
    ): ?array;

    public function findById(
        int $id
    ): ?array;
}