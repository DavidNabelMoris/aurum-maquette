<?php

declare(strict_types=1);

namespace App\Security;

final class Csrf
{
    private const KEY = '_csrf_token';

    public static function token(): string
    {
        $token = Session::get(self::KEY);

        if (!is_string($token)) {
            $token = bin2hex(random_bytes(32));
            Session::put(self::KEY, $token);
        }

        return $token;
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_token" value="' . e(self::token()) . '">';
    }

    public static function verify(mixed $token): bool
    {
        $expected = Session::get(self::KEY);

        return is_string($expected) && is_string($token) && hash_equals($expected, $token);
    }

    /** Rejects cross-site requests whose Origin header does not match this site. */
    public static function sameOrigin(): bool
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? null;

        if ($origin === null) {
            return true;
        }

        $scheme = is_https() ? 'https' : 'http';

        return $origin === "{$scheme}://" . ($_SERVER['HTTP_HOST'] ?? '');
    }
}
