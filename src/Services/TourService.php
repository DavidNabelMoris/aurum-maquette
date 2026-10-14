<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\JsonStore;

final class TourService
{
    private const STATUSES = [
        'confirmed' => ['label' => 'Confirmée', 'tone' => 'success'],
        'pending' => ['label' => 'En attente', 'tone' => 'warning'],
        'cancelled' => ['label' => 'Annulée', 'tone' => 'danger'],
    ];

    private array $tours;

    public function __construct(JsonStore $store)
    {
        $this->tours = $store->read('tours');
        usort($this->tours, fn (array $a, array $b): int => $a['date'] <=> $b['date']);
    }

    public function all(?int $limit = null): array
    {
        return array_slice(array_map([$this, 'present'], $this->tours), 0, $limit);
    }

    public function confirmed(?int $limit = null): array
    {
        $confirmed = array_filter($this->tours, fn (array $tour): bool => $tour['status'] === 'confirmed');

        return array_slice(array_map([$this, 'present'], array_values($confirmed)), 0, $limit);
    }

    private function present(array $tour): array
    {
        $status = self::STATUSES[$tour['status']] ?? ['label' => $tour['status'], 'tone' => 'muted'];

        return $tour + [
            'date_label' => format_date($tour['date']),
            'day' => (new \DateTimeImmutable($tour['date']))->format('d'),
            'month' => format_month($tour['date']),
            'status_label' => $status['label'],
            'status_tone' => $status['tone'],
        ];
    }
}
