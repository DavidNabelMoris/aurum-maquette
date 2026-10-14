<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Appends JSON lines to storage/logs. Never pass passwords or tokens in the context.
 */
final class Logger
{
    public static function security(string $event, array $context = []): void
    {
        self::write('security', $event, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::write('error', $message, $context);
    }

    private static function write(string $channel, string $message, array $context): void
    {
        $line = json_encode([
            'time' => date(DATE_ATOM),
            'ip' => client_ip(),
            'path' => request_path(),
            'message' => $message,
            'context' => $context,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $directory = storage_path('logs');
        $written = (is_dir($directory) || @mkdir($directory, 0775, true))
            && @file_put_contents("{$directory}/{$channel}.log", $line . PHP_EOL, FILE_APPEND | LOCK_EX) !== false;

        if (!$written) {
            error_log("[{$channel}] {$line}");
        }
    }
}
