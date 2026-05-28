<?php

namespace App\Controller;

use App\DTO\LoginDTO;
use App\DTO\RegisterDTO;
use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Service\AuthService;

class AuthController extends BaseController
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(): void
    {
        if (
            $_SERVER['REQUEST_METHOD']
            === 'POST'
        ) {

            $request =
                new RegisterRequest($_POST);

            if (!$request->validate()) {

                $this->render(
                    'auth/register',
                    [
                        'errors' =>
                            $request->errors()
                    ]
                );

                return;
            }

            $dto = new RegisterDTO(

                $request->input('name'),

                $request->input('email'),

                $request->input('password')
            );

            $response =
                $this->authService
                    ->register($dto);

            if ($response->success) {

                $this->redirect(
                    '?page=login'
                );
            }
        }

        $this->render(
            'auth/register',
            [
                'errors' => []
            ]
        );
    }

    public function login(): void
    {
        if (
            $_SERVER['REQUEST_METHOD']
            === 'POST'
        ) {

            $request =
                new LoginRequest($_POST);

            if (!$request->validate()) {

                $this->render(
                    'auth/login',
                    [
                        'errors' =>
                            $request->errors()
                    ]
                );

                return;
            }

            $dto = new LoginDTO(

                $request->input('email'),

                $request->input('password')
            );

            $response =
                $this->authService
                    ->login($dto);

            if ($response->success) {

                $this->redirect(
                    '?page=catalog'
                );
            }

            $this->render(
                'auth/login',
                [
                    'errors' =>
                        $response->errors
                ]
            );

            return;
        }

        $this->render(
            'auth/login',
            [
                'errors' => []
            ]
        );
    }

    public function logout(): void
    {
        $this->authService->logout();

        $this->redirect('?page=login');
    }
}