<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\JsonStore;

final class CompanyService
{
    private array $data;

    public function __construct(JsonStore $store)
    {
        $this->data = $store->read('company');
    }

    public function profile(): array
    {
        return $this->data['profile'];
    }

    public function guarantees(): array
    {
        return $this->data['guarantees'];
    }

    public function purchaseCategories(): array
    {
        return $this->data['purchase_categories'];
    }

    public function channels(): array
    {
        return $this->data['channels'];
    }

    public function exchange(): array
    {
        return $this->data['exchange'];
    }

    public function investment(): array
    {
        return $this->data['investment'];
    }

    public function estimationCategories(): array
    {
        return $this->data['estimation'];
    }

    public function estimationCategory(string $id): ?array
    {
        foreach ($this->estimationCategories() as $category) {
            if ($category['id'] === $id) {
                return $category;
            }
        }

        return null;
    }
}
