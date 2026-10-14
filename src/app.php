<?php

declare(strict_types=1);

use App\Security\SecurityHeaders;

if (config('app.force_https') && !is_https()) {
    header('Location: https://' . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '/'), true, 301);
    exit;
}

SecurityHeaders::send();

$router = require BASE_PATH . '/src/routes.php';
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', request_path());
