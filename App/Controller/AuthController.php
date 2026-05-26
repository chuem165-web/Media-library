<?php

namespace App\Controller;

use App\Service\AuthService;

class AuthController extends BaseController
{
    private AuthService $authService;

    public function __construct(
        AuthService $authService
    ) {
        $this->authService =
            $authService;
    }

    /**
     * Register page
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $result =
                $this->authService
                    ->register(
                        $name,
                        $email,
                        $password
                    );

            if ($result['success']) {
                $this->redirect('?page=login');
            }

            $this->render(
                'auth/register',
                [
                    'error' => $result['message']
                ]
            );

            return;
        }

        $this->render('auth/register');
    }

    /**
     * Login page
     */
   public function login(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $result =
            $this->authService
                ->login(
                    $email,
                    $password
                );

        if ($result['success']) {
            $this->redirect(
                '?page=catalog'
            );
        }

        $this->render(
            'auth/login',
            [
                'error' =>
                    $result['message']
            ]
        );

        return;
    }

    $this->render(
        'auth/login'
    );
}

    /**
     * Logout
     */
    public function logout(): void
    {
        $this->authService->logout();

        $this->redirect('?page=login');
    }
}