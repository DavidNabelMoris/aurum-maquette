<?php

return [
    'admin' => [
        'username' => getenv('ADMIN_USERNAME') ?: 'admin',
        'password_hash' => getenv('ADMIN_PASSWORD_HASH') ?: '$2y$10$A5yctyQNvIBC1TjrU3obxeFCSYRd8/LIOm71I88Ca1uyXYKzeBSEm',
        'idle_timeout' => 1800,
    ],

    'rate_limits' => [
        'login' => ['max' => 5, 'window' => 900],
        'estimation' => ['max' => 5, 'window' => 600],
    ],

    'form_min_seconds' => 3,
    'max_request_bytes' => 16 * 1024,
];
