<?php

namespace App\Service;

use App\Model\User;
use App\Repository\UserRepository;

class AuthService extends BaseService
{
    private UserRepository $userRepository;

    private Validator $validator;

    public function __construct(
        Validator $validator
    ) {

        $this->userRepository =
            new UserRepository(
                $this->db()
            );

        $this->validator =
            $validator;
    }

    /**
     * Register user
     */
    public function register(
        string $name,
        string $email,
        string $password
    ): array {

        $data = [

            'name' => $name,

            'email' => $email,

            'password' => $password
        ];

        $valid =
            $this->validator
                ->validate(

                    $data,

                    User::registerRules()
                );

        if (!$valid) {

            return [

                'success' => false,

                'errors' =>

                    $this->validator
                        ->errors()
            ];
        }

        $existingUser =
            $this->userRepository
                ->findByEmail(
                    $email
                );

        if ($existingUser) {

            return [

                'success' => false,

                'errors' => [

                    'email' => [

                        'Email already exists'
                    ]
                ]
            ];
        }

        $hashedPassword =
            password_hash(

                $password,

                PASSWORD_BCRYPT
            );

        $created =
            $this->userRepository
                ->create(

                    $name,

                    $email,

                    $hashedPassword
                );

        if (!$created) {

            return [

                'success' => false,

                'errors' => [

                    'general' => [

                        'Registration failed'
                    ]
                ]
            ];
        }

        return [

            'success' => true
        ];
    }

    /**
     * Login user
     */
    public function login(
        string $email,
        string $password
    ): array {

        $data = [

            'email' => $email,

            'password' => $password
        ];

        $valid =
            $this->validator
                ->validate(

                    $data,

                    User::loginRules()
                );

        if (!$valid) {

            return [

                'success' => false,

                'errors' =>

                    $this->validator
                        ->errors()
            ];
        }

        $user =
            $this->userRepository
                ->findByEmail(
                    $email
                );

        if (!$user) {

            return [

                'success' => false,

                'errors' => [

                    'email' => [

                        'Invalid email or password'
                    ]
                ]
            ];
        }

        $validPassword =
            password_verify(

                $password,

                $user['password']
            );

        if (!$validPassword) {

            return [

                'success' => false,

                'errors' => [

                    'password' => [

                        'Invalid email or password'
                    ]
                ]
            ];
        }

        $_SESSION['user'] = [

            'id' => $user['id'],

            'name' => $user['name'],

            'email' => $user['email']
        ];

        return [

            'success' => true
        ];
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        unset(
            $_SESSION['user']
        );
    }

    /**
     * Check login
     */
    public function check(): bool
    {
        return isset(
            $_SESSION['user']
        );
    }

    /**
     * Current user
     */
    public function user(): ?array
    {
        return
            $_SESSION['user']
            ?? null;
    }
}