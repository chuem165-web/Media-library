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

    public function register(RegisterDTO $dto): ApiResponseDTO
    {
        $user = User::create(
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

    public function login(LoginDTO $dto): ApiResponseDTO
    {
        $user = $this->users->findByEmail(
            $dto->getEmail()
        );

        if (
            !$user ||
            !$user->verifyPassword($dto->getPassword())
        ) {
            return new ApiResponseDTO(
                false,
                'Invalid credentials',
                null,
                [
                    'email' => 'Wrong email or password'
                ]
            );
        }

        //  SAFE SESSION HANDLING
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ];

        return new ApiResponseDTO(
            true,
            'Login successful',
            $_SESSION['user']
        );
    }

    public function logout(): void
    {
        //  ONLY remove auth data (safe & clean)
        unset($_SESSION['user']);

        // Optional: regenerate session ID for security
        session_regenerate_id(true);
    }
}