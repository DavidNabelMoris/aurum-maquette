<?php

declare(strict_types=1);

namespace App\Security;

final class SecurityHeaders
{
    public static function send(): void
    {
        header_remove('X-Powered-By');

        header('Content-Security-Policy: ' . self::contentSecurityPolicy());
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()');
        header('Cross-Origin-Opener-Policy: same-origin');

        if (config('app.demo')) {
            header('X-Robots-Tag: noindex, nofollow');
        }

        if (is_https()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }

    private static function contentSecurityPolicy(): string
    {
        $scripts = ["'self'", 'https://unpkg.com', 'https://cdnjs.cloudflare.com'];
        $connect = ["'self'"];
        $images = ["'self'", 'data:'];

        if (config('app.analytics.gtm_id')) {
            $scripts[] = 'https://www.googletagmanager.com';
            $connect[] = 'https://www.google-analytics.com';
            $images[] = 'https://www.googletagmanager.com';
        }

        $policy = [
            'default-src' => ["'self'"],
            'script-src' => $scripts,
            'style-src' => ["'self'", 'https://fonts.googleapis.com'],
            'font-src' => ['https://fonts.gstatic.com'],
            'img-src' => $images,
            'connect-src' => $connect,
            'frame-ancestors' => ["'none'"],
            'base-uri' => ["'self'"],
            'form-action' => ["'self'"],
            'object-src' => ["'none'"],
        ];

        return implode('; ', array_map(fn (string $directive, array $sources): string => $directive . ' ' . implode(' ', $sources), array_keys($policy), $policy));
    }
}
