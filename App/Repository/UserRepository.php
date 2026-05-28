<?php

namespace App\Repository;

use App\Mapper\UserMapper;
use App\Model\User;
use PDO;

class UserRepository extends BaseRepository
{
    protected string $table = 'users';

    public function create(
        User $user
    ): bool {

        $sql = "

            INSERT INTO users(
                name,
                email,
                password
            )

            VALUES(
                :name,
                :email,
                :password
            )
        ";

        $stmt = $this->query($sql);

        return $stmt->execute([

            ':name' =>
                $user->getName(),

            ':email' =>
                $user->getEmail(),

            ':password' =>
                $user->getPasswordHash()
        ]);
    }

    public function findByEmail(
        string $email
    ): ?User {

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

        $data =
            $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return UserMapper::mapToEntity($data);
    }
}