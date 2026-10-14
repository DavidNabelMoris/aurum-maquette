<?php

return [
    'admin' => [
        'username' => getenv('ADMIN_USERNAME') ?: 'admin',
        // The fallback hash is for the local dev server only: anywhere else ADMIN_PASSWORD_HASH must be set.
        'password_hash' => getenv('ADMIN_PASSWORD_HASH') ?: (PHP_SAPI === 'cli-server' ? '$2y$10$A5yctyQNvIBC1TjrU3obxeFCSYRd8/LIOm71I88Ca1uyXYKzeBSEm' : null),
        'idle_timeout' => 1800,
    ],

    'rate_limits' => [
        'login' => ['max' => 5, 'window' => 900],
        'estimation' => ['max' => 5, 'window' => 600],
    ],

    'form_min_seconds' => 3,
    'max_request_bytes' => 16 * 1024,
];
