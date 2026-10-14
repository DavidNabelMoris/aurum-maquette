<?php

return [
    'admin' => [
        'username' => env('ADMIN_USERNAME') ?? 'admin',
        'password_hash' => env('ADMIN_PASSWORD_HASH') ?? config('local.admin_password_hash'),
        'idle_timeout' => 1800,
    ],

    'rate_limits' => [
        'login' => ['max' => 5, 'window' => 900],
        'estimation' => ['max' => 5, 'window' => 600],
    ],

    'form_min_seconds' => 3,
    'max_request_bytes' => 16 * 1024,
];
