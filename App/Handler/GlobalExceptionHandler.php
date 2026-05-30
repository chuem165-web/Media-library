<?php

namespace App\Handler;

use App\Exceptions\BaseException;
use Throwable;

class GlobalExceptionHandler
{
    public static function handle(Throwable $e): void
    {
        // =========================
        // 1. LOG ERROR
        // =========================
        error_log(
            '[' . date('Y-m-d H:i:s') . '] ' .
            $e->getMessage() .
            ' in ' . $e->getFile() .
            ' on line ' . $e->getLine()
        );

        // =========================
        // 2. PREVENT DOUBLE OUTPUT
        // =========================
        if (ob_get_length()) {
            ob_clean();
        }

        // =========================
        // 3. API HANDLING
        // =========================
        if (isset($_GET['page']) && str_starts_with($_GET['page'], 'api/')) {
            self::jsonResponse($e);
            return;
        }

        // =========================
        // 4. WEB HANDLING
        // =========================
        self::webResponse($e);
    }

    private static function jsonResponse(Throwable $e): void
    {
        http_response_code(self::getStatusCode($e));
        header('Content-Type: application/json');

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'code'    => self::getStatusCode($e),
        ]);

        exit;
    }

    private static function webResponse(Throwable $e): void
    {
        http_response_code(self::getStatusCode($e));

        // $view = self::getStatusCode($e) === 404
        //     ? 'errors/404'
        //     : 'errors/500';

        $statusCode = self::getStatusCode($e);

$view = match ($statusCode) {
    403 => 'errors/403',
    404 => 'errors/404',
    422 => 'errors/422',
    default => 'errors/500',
};

        $file = BASE_PATH . '/view/' . $view . '.php';

        // =========================
        // SAFE FALLBACK (VERY IMPORTANT)
        // =========================
        if (file_exists($file)) {
            require $file;
        } else {
            echo "<h1>" . self::getStatusCode($e) . " Error</h1>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        }

        exit;
    }

    private static function getStatusCode(Throwable $e): int
    {
        if ($e instanceof BaseException) {
            return $e->getStatusCode();
        }

        return 500;
    }
}