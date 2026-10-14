<?php

declare(strict_types=1);

namespace App\Data;

use RuntimeException;

final class JsonStore
{
    public function __construct(private readonly string $directory)
    {
    }

    public function has(string $name): bool
    {
        return is_file($this->path($name));
    }

    public function read(string $name): array
    {
        if (!$this->has($name)) {
            throw new RuntimeException("Data file not found: {$name}");
        }

        return json_decode((string) file_get_contents($this->path($name)), true, 512, JSON_THROW_ON_ERROR);
    }

    public function write(string $name, array $data): void
    {
        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0775, true);
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        if (file_put_contents($this->path($name), $json, LOCK_EX) === false) {
            throw new RuntimeException("Could not write data file: {$name}");
        }
    }

    private function path(string $name): string
    {
        return $this->directory . '/' . $name . '.json';
    }
}
