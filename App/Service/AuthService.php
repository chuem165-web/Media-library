<?php

namespace App\Service;

use App\DTO\ApiResponseDTO;
use App\DTO\LoginDTO;
use App\DTO\RegisterDTO;
use App\Model\User;
use App\Repository\UserRepository;

class AuthService
{
    public function __construct(
        private UserRepository $users
    ) {}

    public function register(
        RegisterDTO $dto
    ): ApiResponseDTO {

        $user = User::create(

            // CHANGED: now using getters instead of direct property access
            $dto->getName(),
            $dto->getEmail(),
            $dto->getPassword()
        );

        $this->users->create($user);

        return new ApiResponseDTO(
            true,
            'Registration successful'
        );
    }

    public function login(
        LoginDTO $dto
    ): ApiResponseDTO {

        $user =
            $this->users
                ->findByEmail(

                    // CHANGED: fixed private property access → getter
                    $dto->getEmail()
                );

        if (
            !$user ||
            !$user->verifyPassword(

                // CHANGED: fixed private property access → getter
                $dto->getPassword()
            )
        ) {

            return new ApiResponseDTO(
                false,
                'Invalid credentials',
                null,
                [
                    'email' =>
                        'Wrong email or password'
                ]
            );
        }

        $_SESSION['user'] =
            $user->toArray();

        return new ApiResponseDTO(
            true,
            'Login successful',
            $user->toArray()
        );
    }

    public function logout(): void
    {
        session_destroy();
    }
}