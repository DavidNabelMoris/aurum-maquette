<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Security\Encrypter;
use App\Security\Session;
use App\Services\CompanyService;
use App\Services\DashboardService;
use App\Services\EstimationService;
use App\Support\Logger;

final class ApiController
{
    public function stats(): void
    {
        $dashboard = new DashboardService(data_store());
        $period = clean_text($_GET['period'] ?? 'month', 10);
        $volume = $dashboard->volume($period);

        if ($volume === null) {
            json_response(['error' => 'Période inconnue'], 400);
        }

        json_response([
            'period' => $period,
            'volume' => $volume,
            'transactions' => $dashboard->transactions(),
        ]);
    }

    public function storeEstimation(): void
    {
        $input = $this->readJsonBody();

        if (!empty($input['website']) || !$this->filledByHuman()) {
            Logger::security('estimation.bot_rejected');
            json_response(['reference' => null], 201);
        }

        $limit = config('security.rate_limits.estimation');
        $key = 'estimation:' . client_ip();
        $limiter = rate_limiter();

        if ($limiter->tooManyAttempts($key, $limit['max'], $limit['window'])) {
            Logger::security('estimation.rate_limited');
            header('Retry-After: ' . $limiter->availableIn($key, $limit['window']));
            json_response(['error' => 'Trop de demandes envoyées. Réessayez dans quelques minutes ou appelez-nous.'], 429);
        }

        $estimations = new EstimationService(storage_store(), new CompanyService(data_store()), new Encrypter());
        $data = $estimations->normalize($input);
        $errors = $estimations->validate($data);

        if ($errors !== []) {
            json_response(['errors' => $errors], 422);
        }

        $limiter->hit($key, $limit['window']);
        $estimation = $estimations->create($data);

        json_response(['reference' => $estimation['reference']], 201);
    }

    private function readJsonBody(): array
    {
        $maxBytes = config('security.max_request_bytes');

        if ((int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > $maxBytes) {
            json_response(['error' => 'Requête trop volumineuse'], 413);
        }

        if (!str_starts_with($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
            json_response(['error' => 'Format attendu : JSON'], 415);
        }

        $body = (string) file_get_contents('php://input', false, null, 0, $maxBytes + 1);
        if (strlen($body) > $maxBytes) {
            json_response(['error' => 'Requête trop volumineuse'], 413);
        }

        $input = json_decode($body, true);
        if (!is_array($input)) {
            json_response(['error' => 'Requête invalide'], 400);
        }

        return $input;
    }

    /** A person needs more than a few seconds to go through the three steps of the form. */
    private function filledByHuman(): bool
    {
        $renderedAt = (int) Session::get(SiteController::FORM_RENDERED_AT, 0);

        return $renderedAt > 0 && time() - $renderedAt >= config('security.form_min_seconds');
    }
}
