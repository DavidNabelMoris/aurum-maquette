<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Security\Csrf;
use App\Support\Logger;

final class AuthController
{
    public function showLogin(?string $error = null, string $username = '', int $status = 200): void
    {
        if (auth()->check()) {
            redirect('/admin');
        }

        if ($error === null && isset($_GET['expired'])) {
            $error = 'Votre session a expiré. Reconnectez-vous.';
        }

        view('pages/admin/login', [
            'title' => 'Connexion',
            'error' => $error,
            'username' => $username,
            'csrfField' => Csrf::field(),
        ], 'auth', $status);
    }

    public function login(): void
    {
        $username = clean_text($_POST['username'] ?? '', 100);
        $password = is_string($_POST['password'] ?? null) ? mb_substr($_POST['password'], 0, 200) : '';

        $result = auth()->attempt($username, $password);

        if (!$result['ok']) {
            $this->showLogin($result['error'], $username, 422);

            return;
        }

        redirect('/admin');
    }

    public function logout(): void
    {
        Logger::security('logout', ['username' => auth()->user()]);
        auth()->logout();
        redirect('/admin/login');
    }
}
