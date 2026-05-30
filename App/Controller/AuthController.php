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

    /**
     * REGISTER FLOW
     */
    public function register(): void
    {
        // CHANGE: Keep GET request for form display
        if (!$this->isPost()) {
            $this->render('auth/register', [
                'errors' => []
            ]);
            return;
        }

        $request = new RegisterRequest($_POST);

        //  CHANGE: stop execution if validation fails (already rendering inside BaseController)
        if (!$this->validateRequest($request, 'auth/register')) {
            return;
        }

        $dto = new RegisterDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $response = $this->authService->register($dto);

        //  CHANGE: centralized response handler (redirect or render errors)
        $this->handleResponse(
            $response,
            '?page=login',      // success redirect
            'auth/register'     // failure view
        );
    }

    /**
     * LOGIN FLOW
     */
    public function login(): void
    {
        //  CHANGE: GET request shows login page
        if (!$this->isPost()) {
            $this->render('auth/login', [
                'errors' => []
            ]);
            return;
        }

        $request = new LoginRequest($_POST);

        //  CHANGE: stop if validation fails
        if (!$this->validateRequest($request, 'auth/login')) {
            return;
        }

        $dto = new LoginDTO(
            $request->input('email'),
            $request->input('password')
        );

        $response = $this->authService->login($dto);

        // CHANGE: on success redirect to catalog
        $this->handleResponse(
            $response,
            '?page=catalog',
            'auth/login'
        );
    }
     /**
     * LOGOUT FLOW
     */
     public function logout(): void
    {
        //  CHANGE: delegate session cleanup to service
        $this->authService->logout();

       //  CHANGE: always redirect after logout
        $this->redirect('?page=login');
    }
 }