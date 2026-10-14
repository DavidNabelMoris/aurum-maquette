<?php

declare(strict_types=1);

namespace App\Http;

use App\Controllers\SiteController;
use App\Security\Csrf;
use App\Support\Logger;

final class Router
{
    /** @var array<string, array<string, array{handler: array{class-string, string}, auth: bool, csrf: bool}>> */
    private array $routes = [];

    public function get(string $path, array $handler, bool $auth = false): void
    {
        $this->add('GET', $path, $handler, $auth, csrf: false);
    }

    public function post(string $path, array $handler, bool $auth = false, bool $csrf = true): void
    {
        $this->add('POST', $path, $handler, $auth, $csrf);
    }

    public function dispatch(string $method, string $path): void
    {
        $method = $method === 'HEAD' ? 'GET' : $method;
        $route = $this->routes[$path][$method] ?? null;

        if ($route === null) {
            isset($this->routes[$path]) ? $this->methodNotAllowed($path) : $this->notFound();

            return;
        }

        if ($route['auth'] && !auth()->check()) {
            Logger::security('auth.required');
            wants_json() ? json_response(['error' => 'Authentification requise'], 401) : redirect('/admin/login');
        }

        if ($route['csrf'] && !$this->csrfIsValid()) {
            Logger::security('csrf.rejected');
            $message = 'Votre session a expiré. Rechargez la page puis réessayez.';
            wants_json() ? json_response(['error' => $message], 419) : redirect('/admin/login?expired=1');
        }

        [$class, $action] = $route['handler'];
        (new $class())->$action();
    }

    private function add(string $method, string $path, array $handler, bool $auth, bool $csrf): void
    {
        $this->routes[$path][$method] = ['handler' => $handler, 'auth' => $auth, 'csrf' => $csrf];
    }

    private function csrfIsValid(): bool
    {
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['_token'] ?? null;

        return Csrf::sameOrigin() && Csrf::verify($token);
    }

    private function methodNotAllowed(string $path): void
    {
        header('Allow: ' . implode(', ', array_keys($this->routes[$path])));
        wants_json() ? json_response(['error' => 'Méthode non autorisée'], 405) : $this->notFound();
    }

    private function notFound(): void
    {
        wants_json() ? json_response(['error' => 'Ressource introuvable'], 404) : (new SiteController())->notFound();
    }
}
