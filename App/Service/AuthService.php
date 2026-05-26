<?php

class AuthService extends BaseService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository =
            new UserRepository(
                $this->db()
            );
    }

    /**
     * Register user
     */
    public function register(
        string $name,
        string $email,
        string $password
    ): array {

        $existingUser =
            $this->userRepository
                ->findByEmail($email);

        if ($existingUser) {
            return [
                'success' => false,
                'message' => 'Email already exists'
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
                'message' => 'Registration failed'
            ];
        }

        return [
            'success' => true,
            'message' => 'Registration successful'
        ];
    }

    /**
     * Login user
     */
    public function login(
        string $email,
        string $password
    ): array {

        $user =
            $this->userRepository
                ->findByEmail($email);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid email or password'
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
                'message' => 'Invalid email or password'
            ];
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];

        return [
            'success' => true,
            'message' => 'Login successful'
        ];
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * Check login
     */
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Current user
     */
    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}