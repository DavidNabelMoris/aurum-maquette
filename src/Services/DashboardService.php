<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\JsonStore;

final class DashboardService
{
    private array $data;

    public function __construct(JsonStore $store)
    {
        $this->data = $store->read('dashboard');
    }

    public function kpis(): array
    {
        return array_map(fn (array $kpi): array => $kpi + [
            'display' => $kpi['format'] === 'currency'
                ? format_currency($kpi['value'], 0)
                : format_number($kpi['value']),
        ], $this->data['kpis']);
    }

    public function volume(string $period): ?array
    {
        return $this->data['volume'][$period] ?? null;
    }

    public function transactions(): array
    {
        return $this->data['transactions'];
    }

    public function requestsByChannel(): array
    {
        $channels = $this->data['requests_by_channel'];
        $total = array_sum(array_column($channels, 'count')) ?: 1;

        return array_map(fn (array $channel): array => $channel + [
            'share' => (int) round($channel['count'] / $total * 100),
        ], $channels);
    }
}
