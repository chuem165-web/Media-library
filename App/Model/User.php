<?php

namespace App\Model;

class User
{
    private ?int $id;

    private string $name;

    private string $email;

    private string $passwordHash;

    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $passwordHash
    ) {
        $this->id = $id;

        $this->name = $name;

        $this->email = $email;

        $this->passwordHash = $passwordHash;
    }

    public static function create(
        string $name,
        string $email,
        string $password
    ): self {

        return new self(
            null,
            $name,
            $email,
            password_hash(
                $password,
                PASSWORD_BCRYPT
            )
        );
    }

    public function verifyPassword(
        string $password
    ): bool {

        return password_verify(
            $password,
            $this->passwordHash
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function toArray(): array
    {
        return [

            'id' => $this->id,

            'name' => $this->name,

            'email' => $this->email
        ];
    }
}