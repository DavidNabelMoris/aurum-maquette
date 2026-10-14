<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

if (PHP_SAPI === 'cli-server' && request_path() !== '/' && is_file(__DIR__ . request_path())) {
    return false;
}

require BASE_PATH . '/src/app.php';
