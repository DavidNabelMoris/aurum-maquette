<?php

declare(strict_types=1);

use App\Data\JsonStore;

/**
 * Reads a configuration value with dot notation: "app.name", "security.admin.username".
 */
function config(string $key, mixed $default = null): mixed
{
    static $files = [];

    $segments = explode('.', $key);
    $file = array_shift($segments);
    $files[$file] ??= is_file(BASE_PATH . "/config/{$file}.php") ? require BASE_PATH . "/config/{$file}.php" : [];

    $value = $files[$file];
    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

/**
 * Reads an environment variable whichever way the PHP runtime exposes it.
 */
function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    if ($value === false) {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? null;
    }

    return is_string($value) && $value !== '' ? $value : $default;
}

/**
 * Writable folder for application data: STORAGE_PATH, else ./storage, else the system temp folder
 * (serverless hosts such as Vercel only allow writing there).
 */
function storage_path(string $path = ''): string
{
    static $base = null;

    if ($base === null) {
        $local = BASE_PATH . '/storage';
        $base = env('STORAGE_PATH')
            ?? ((is_dir($local) && is_writable($local)) || is_writable(BASE_PATH) ? $local : sys_get_temp_dir() . '/aurum');
        $base = rtrim($base, '/');
    }

    return $path === '' ? $base : $base . '/' . ltrim($path, '/');
}

function data_store(): JsonStore
{
    static $store = null;

    return $store ??= new JsonStore(BASE_PATH . '/data');
}

function storage_store(): JsonStore
{
    static $store = null;

    return $store ??= new JsonStore(storage_path());
}

function rate_limiter(): App\Security\RateLimiter
{
    static $limiter = null;

    return $limiter ??= new App\Security\RateLimiter(storage_path('rate-limits'));
}

function auth(): App\Security\Auth
{
    static $auth = null;

    return $auth ??= new App\Security\Auth(rate_limiter());
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    return rtrim(config('app.base_url', ''), '/') . '/' . ltrim($path, '/');
}

function absolute_url(string $path = ''): string
{
    return rtrim(config('app.url'), '/') . url($path);
}

function asset(string $path): string
{
    $path = ltrim($path, '/');
    $file = BASE_PATH . '/public/assets/' . $path;
    $version = is_file($file) ? filemtime($file) : 0;

    return url('assets/' . $path) . '?v=' . $version;
}

function vendor_script(string $name): string
{
    $vendor = config("app.vendors.{$name}");

    return sprintf('<script src="%s" integrity="%s" crossorigin="anonymous" referrerpolicy="no-referrer"></script>', e($vendor['src']), e($vendor['integrity']));
}

function render(string $template, array $data = []): string
{
    extract($data, EXTR_SKIP);
    ob_start();
    require BASE_PATH . '/templates/' . $template . '.php';

    return (string) ob_get_clean();
}

function view(string $template, array $data, string $layout, int $status = 200): void
{
    http_response_code($status);
    $data['content'] = render($template, $data);
    echo render('layouts/' . $layout, $data);
}

function partial(string $name, array $data = []): void
{
    echo render('partials/' . $name, $data);
}

function json_response(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

function redirect(string $path, int $status = 303): never
{
    header('Location: ' . url($path), true, $status);
    exit;
}

function request_path(): string
{
    $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $base = rtrim(config('app.base_url', ''), '/');

    if ($base !== '' && str_starts_with($path, $base)) {
        $path = substr($path, strlen($base));
    }

    return '/' . trim($path, '/');
}

function wants_json(): bool
{
    return str_starts_with(request_path(), '/api/') || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
}

function is_https(): bool
{
    if (config('app.trust_proxy') && isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        return $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https';
    }

    return ($_SERVER['HTTPS'] ?? '') === 'on' || ($_SERVER['SERVER_PORT'] ?? '') === '443';
}

/**
 * Behind a trusted proxy (e.g. Vercel), the first X-Forwarded-For address is the visitor.
 */
function client_ip(): string
{
    if (config('app.trust_proxy') && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    }

    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

/**
 * Trims a user-supplied string, removes control characters and collapses repeated spaces.
 */
function clean_text(mixed $value, int $maxLength, bool $multiline = false): string
{
    $text = is_scalar($value) ? (string) $value : '';
    $text = $multiline
        ? preg_replace('/[^\P{C}\n]+/u', '', str_replace("\r\n", "\n", $text))
        : preg_replace('/\p{C}+/u', ' ', $text);
    $text = preg_replace('/[ \t]+/u', ' ', (string) $text);

    return mb_substr(trim((string) $text), 0, $maxLength);
}

function format_number(float $value, int $decimals = 0): string
{
    return number_format($value, $decimals, ',', "\u{00A0}");
}

function format_currency(float $value, int $decimals = 2): string
{
    return format_number($value, $decimals) . "\u{00A0}€";
}

function format_percent(float $value, bool $signed = false, int $decimals = 2): string
{
    $sign = $signed && $value > 0 ? '+' : '';

    return $sign . format_number($value, $decimals) . "\u{00A0}%";
}

function format_date(string $date): string
{
    $days = ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'];
    $time = new DateTimeImmutable($date);

    return sprintf('%s %d %s', $days[(int) $time->format('w')], (int) $time->format('j'), format_month($date));
}

function format_month(string $date): string
{
    $months = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];

    return $months[(int) (new DateTimeImmutable($date))->format('n') - 1];
}

/**
 * Lowercase, accent-free version of a French string, for alphabetical sorting without the intl extension.
 */
function sort_key(string $value): string
{
    return strtr(mb_strtolower($value), [
        'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ç' => 'c', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'î' => 'i', 'ï' => 'i', 'ô' => 'o', 'ö' => 'o', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ÿ' => 'y',
    ]);
}

/**
 * Escapes a text and wraps the accent words in a span, e.g. for headings set in two typefaces.
 */
function with_accent(string $text, string $accent = ''): string
{
    $escaped = nl2br(e($text), false);

    if ($accent === '') {
        return $escaped;
    }

    return str_replace(e($accent), '<span class="accent">' . e($accent) . '</span>', $escaped);
}

function format_datetime(string $date): string
{
    return (new DateTimeImmutable($date))->format('d/m/Y à H:i');
}

/**
 * Builds SVG path data for a sparkline: the line itself and the filled area below it.
 */
function sparkline(array $values, int $width = 600, int $height = 160, int $padding = 8): array
{
    $values = array_values($values);
    $min = min($values);
    $range = (max($values) - $min) ?: 1;
    $step = $width / max(count($values) - 1, 1);

    $points = [];
    foreach ($values as $index => $value) {
        $x = round($index * $step, 2);
        $y = round($padding + ($height - 2 * $padding) * (1 - ($value - $min) / $range), 2);
        $points[] = "{$x},{$y}";
    }

    $line = 'M' . implode(' L', $points);

    return [
        'line' => $line,
        'area' => "{$line} L{$width},{$height} L0,{$height} Z",
        'viewBox' => "0 0 {$width} {$height}",
    ];
}
