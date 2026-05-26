<?php

namespace App\Controller;

abstract class BaseController
{
    /**
     * Load view file
     */
    protected function render( /**render() is responsible for loading view pages and sending data from controller to view. */
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
     * Redirect helper
     */
     protected function redirect( /**redirect() changes page location and exit prevents remaining code from running. */
        string $url
    ): void {
        header(
            "Location: " . $url
        );

        exit;
    }

    /**
     * Get sanitized input
     */
    protected function input(
        int $type,
        string $key,
        int $filter = FILTER_DEFAULT
    ) {
        return filter_input(
            $type,
            $key,
            $filter
        );
    }
}