<?php

declare(strict_types=1);

use App\Support\Logger;

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $file = BASE_PATH . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

require BASE_PATH . '/src/helpers.php';

error_reporting(E_ALL);
ini_set('display_errors', config('app.debug') ? '1' : '0');
ini_set('log_errors', '1');

if (is_dir(storage_path('logs')) || @mkdir(storage_path('logs'), 0775, true)) {
    ini_set('error_log', storage_path('logs/php-error.log'));
}

set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }

    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function (Throwable $exception): void {
    Logger::error($exception->getMessage(), [
        'type' => $exception::class,
        'file' => $exception->getFile() . ':' . $exception->getLine(),
    ]);

    if (config('app.debug')) {
        throw $exception;
    }

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (wants_json()) {
        json_response(['error' => 'Le service est momentanément indisponible. Réessayez plus tard.'], 500);
    }

    http_response_code(500);
    echo render('pages/errors/server-error');
});
