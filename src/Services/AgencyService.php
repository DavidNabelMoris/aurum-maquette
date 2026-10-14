<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\JsonStore;

final class AgencyService
{
    private array $data;

    public function __construct(JsonStore $store)
    {
        $this->data = $store->read('agencies');
    }

    public function all(): array
    {
        $agencies = array_map(fn (array $agency): array => $agency + [
            'head_office' => false,
            'region_label' => $this->data['regions'][$agency['region']],
        ], $this->data['agencies']);

        usort($agencies, fn (array $a, array $b): int => [$b['head_office'], sort_key($a['city'])] <=> [$a['head_office'], sort_key($b['city'])]);

        return $agencies;
    }

    /**
     * Regions that have at least one agency, with their agency count, largest first.
     */
    public function regions(): array
    {
        $counts = array_count_values(array_column($this->data['agencies'], 'region'));
        arsort($counts);

        $regions = [];
        foreach ($counts as $id => $count) {
            $regions[] = ['id' => $id, 'label' => $this->data['regions'][$id], 'count' => $count];
        }

        return $regions;
    }

    public function count(): int
    {
        return count($this->data['agencies']);
    }
}
