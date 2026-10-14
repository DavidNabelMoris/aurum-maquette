<?php

declare(strict_types=1);

namespace App\Security;

/**
 * Sliding-window counter stored in one small file per key.
 */
final class RateLimiter
{
    public function __construct(private readonly string $directory)
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }
    }

    public function tooManyAttempts(string $key, int $max, int $window): bool
    {
        return count($this->attempts($key, $window)) >= $max;
    }

    public function hit(string $key, int $window): void
    {
        $attempts = $this->attempts($key, $window);
        $attempts[] = time();
        file_put_contents($this->path($key), json_encode($attempts), LOCK_EX);
    }

    public function clear(string $key): void
    {
        if (is_file($this->path($key))) {
            unlink($this->path($key));
        }
    }

    public function availableIn(string $key, int $window): int
    {
        $attempts = $this->attempts($key, $window);

        return $attempts === [] ? 0 : max(0, $attempts[0] + $window - time());
    }

    private function attempts(string $key, int $window): array
    {
        $file = $this->path($key);
        if (!is_file($file)) {
            return [];
        }

        $attempts = json_decode((string) file_get_contents($file), true) ?: [];
        $since = time() - $window;

        return array_values(array_filter($attempts, fn (int $time): bool => $time > $since));
    }

    private function path(string $key): string
    {
        return $this->directory . '/' . hash('sha256', $key) . '.json';
    }
}
