<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\JsonStore;

final class MetalPriceService
{
    private const GRAMS_PER_TROY_OUNCE = 31.1034768;

    private array $data;

    public function __construct(JsonStore $store)
    {
        $this->data = $store->read('metals');
    }

    public function all(): array
    {
        return array_map(fn (array $metal): array => $metal + [
            'eur_per_oz' => round($metal['eur_per_kg'] * self::GRAMS_PER_TROY_OUNCE / 1000, 2),
        ], $this->data['metals']);
    }

    public function find(string $id): ?array
    {
        foreach ($this->all() as $metal) {
            if ($metal['id'] === $id) {
                return $metal;
            }
        }

        return null;
    }

    public function updatedAt(): string
    {
        return $this->data['updated_at'];
    }

    public function source(): string
    {
        return $this->data['source'];
    }
}
