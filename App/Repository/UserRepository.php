<?php

use App\Contract\UserRepositoryInterface;

class UserRepository
    extends BaseRepository
    implements UserRepositoryInterface
{
     protected string $table = 'users';
    public function create(
        string $name,
        string $email,
        string $password
    ): bool {

        $sql = "
            INSERT INTO users (
                name,
                email,
                password
            )
            VALUES (
                :name,
                :email,
                :password
            )
        ";

        $stmt = $this->query($sql);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);
    }

    public function findByEmail(
        string $email
    ): ?array {

        $sql = "
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = $this->query($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findById(
        int $id
    ): ?array {

        $sql = "
            SELECT *
            FROM users
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->query($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

}