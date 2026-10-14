<?php

declare(strict_types=1);

namespace App\Security;

use App\Support\Logger;

final class Auth
{
    private const SESSION_USER = 'auth_user';
    private const SESSION_SEEN = 'auth_last_seen';

    /** Used when the username is unknown, so a wrong username takes as long as a wrong password. */
    private const DUMMY_HASH = '$2y$10$jscysk69VNLzzdYfm4Gc9ec2w2t/4xRE72utMCldO9Hso7NPThQOm';

    public function __construct(private readonly RateLimiter $limiter)
    {
    }

    /**
     * @return array{ok: bool, error?: string}
     */
    public function attempt(string $username, string $password): array
    {
        $limit = config('security.rate_limits.login');
        $keys = ['login-ip:' . client_ip(), 'login-user:' . mb_strtolower($username)];

        foreach ($keys as $key) {
            if ($this->limiter->tooManyAttempts($key, $limit['max'], $limit['window'])) {
                Logger::security('login.locked', ['username' => $username]);
                $minutes = (int) ceil($this->limiter->availableIn($key, $limit['window']) / 60);

                return ['ok' => false, 'error' => "Trop de tentatives. Réessayez dans {$minutes} min."];
            }
        }

        $admin = config('security.admin');
        $knownUser = $admin['password_hash'] !== null && hash_equals($admin['username'], $username);
        $validPassword = password_verify($password, $knownUser ? $admin['password_hash'] : self::DUMMY_HASH);

        if (!$knownUser || !$validPassword) {
            foreach ($keys as $key) {
                $this->limiter->hit($key, $limit['window']);
            }
            Logger::security('login.failed', ['username' => $username]);

            return ['ok' => false, 'error' => 'Identifiant ou mot de passe incorrect.'];
        }

        foreach ($keys as $key) {
            $this->limiter->clear($key);
        }

        Session::regenerate();
        Session::put(self::SESSION_USER, $admin['username']);
        Session::put(self::SESSION_SEEN, time());
        Logger::security('login.success', ['username' => $username]);

        return ['ok' => true];
    }

    public function check(): bool
    {
        $user = Session::get(self::SESSION_USER);
        $lastSeen = (int) Session::get(self::SESSION_SEEN, 0);

        if ($user === null) {
            return false;
        }

        if (time() - $lastSeen > config('security.admin.idle_timeout')) {
            Logger::security('session.expired', ['username' => $user]);
            $this->logout();

            return false;
        }

        Session::put(self::SESSION_SEEN, time());

        return true;
    }

    public function user(): ?string
    {
        return Session::get(self::SESSION_USER);
    }

    public function logout(): void
    {
        Session::destroy();
    }
}
