<?php

declare(strict_types=1);

namespace App\Security;

use RuntimeException;

/**
 * AES-256-GCM encryption for personal data at rest.
 * The key comes from APP_KEY (base64) or is generated once into storage/app.key.
 */
final class Encrypter
{
    private const CIPHER = 'aes-256-gcm';
    private const PREFIX = 'enc:v1:';

    private string $key;

    public function __construct(?string $key = null)
    {
        $this->key = $key ?? self::loadKey();
    }

    public function encrypt(string $value): string
    {
        $iv = random_bytes(12);
        $cipherText = openssl_encrypt($value, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv, $tag);

        if ($cipherText === false) {
            throw new RuntimeException('Encryption failed');
        }

        return self::PREFIX . base64_encode($iv . $tag . $cipherText);
    }

    public function decrypt(string $payload): string
    {
        if (!str_starts_with($payload, self::PREFIX)) {
            return $payload;
        }

        $raw = base64_decode(substr($payload, strlen(self::PREFIX)), true);
        $plain = $raw === false ? false : openssl_decrypt(substr($raw, 28), self::CIPHER, $this->key, OPENSSL_RAW_DATA, substr($raw, 0, 12), substr($raw, 12, 16));

        if ($plain === false) {
            throw new RuntimeException('Decryption failed');
        }

        return $plain;
    }

    private static function loadKey(): string
    {
        $fromEnv = getenv('APP_KEY');
        if ($fromEnv !== false && $fromEnv !== '') {
            return base64_decode($fromEnv, true) ?: throw new RuntimeException('APP_KEY must be base64');
        }

        $file = storage_path('app.key');
        if (!is_file($file)) {
            if (!is_dir(dirname($file))) {
                mkdir(dirname($file), 0775, true);
            }
            file_put_contents($file, base64_encode(random_bytes(32)), LOCK_EX);
        }

        return base64_decode(trim((string) file_get_contents($file)), true);
    }
}
