<?php

namespace App\Helper;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ?page=login');
            exit;
        }
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }
}