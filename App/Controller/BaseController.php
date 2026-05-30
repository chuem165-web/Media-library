<?php

namespace App\Controller;

use App\Helper\Auth;
use App\Http\Request\FormRequest;

abstract class BaseController
{
    /**
     * Require login
     */
    protected function requireAuth(): void
    {
        Auth::requireLogin();
    }

    /**
     * Render view
     */
    protected function render(
        string $view,
        array $data = []
    ): void {

        extract($data);

        require BASE_PATH
            . '/view/'
            . $view
            . '.php';
    }

    /**
     * Redirect
     */
    protected function redirect(
        string $url
    ): void {

        header(
            'Location: ' . $url);

        exit;
    }

    /**
     * Check POST request
     */
    protected function isPost(): bool
    {
        return $_SERVER[
            'REQUEST_METHOD'
        ] === 'POST';
    }

    /**
     * Validate form request
     */
    protected function validateRequest(
        FormRequest $request,
        string $view,
        array $data = []
    ): bool {

        if (!$request->validate()) {

            $this->render(
                $view,
                array_merge(
                    $data,
                    [
                        'errors' =>
                            $request->errors()
                    ]
                )
            );

            return false;
        }

        return true;
    }

    /**
     * Handle service response
     */
    protected function handleResponse(
        object $response,
        string $successRedirect,
        string $view,
        array $data = []
    ): void {

        if ($response->success) {

            $this->redirect(
                $successRedirect
            );
        }

        $this->render(
            $view,
            array_merge(
                $data,
                [
                    'errors' =>
                        $response->errors ?? []
                ]
            )
        );
    }

    /**
     * Get sanitized GET/POST input
     */
    protected function input(
        int $type,
        string $key,
        int $filter = FILTER_DEFAULT
    ): mixed {

        return filter_input(
            $type,
            $key,
            $filter
        );
    }

    /**
     * Render 404
     */
    protected function notFound(): void
    {
        http_response_code(404);

        $this->render(
            'errors/404'
        );

        exit;
    }
}