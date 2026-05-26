<?php
declare(strict_types=1);

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();

        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::start();

        return isset($_SESSION[$key]);
    }

    public static function delete(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        self::start();
        session_destroy();
        $_SESSION = [];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function user(): ?array
    {
        $user = self::get('user');

        return is_array($user) ? $user : null;
    }

    public static function isLoggedIn(): bool
    {
        return self::has('user');
    }

    public static function isAdmin(): bool
    {
        $user = self::user();

        return $user !== null && ($user['role'] ?? '') === 'admin';
    }

    public static function setFlash(string $key, mixed $value): void
    {
        self::start();
        $_SESSION['_flash'][$key] = $value;
    }

    public static function getFlash(string $key, mixed $default = null): mixed
    {
        self::start();
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);

        return $value;
    }

    public static function hasFlash(string $key): bool
    {
        self::start();

        return isset($_SESSION['_flash'][$key]);
    }
}
