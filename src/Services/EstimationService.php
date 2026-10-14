<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\JsonStore;
use App\Security\Encrypter;

final class EstimationService
{
    private const FILE = 'estimations';
    private const PHONE_PATTERN = '/^(?:\+33\s?|0)[1-9](?:[\s.-]?\d{2}){4}$/';
    private const PERSONAL_FIELDS = ['name', 'phone', 'email', 'note'];

    public function __construct(
        private readonly JsonStore $storage,
        private readonly CompanyService $company,
        private readonly Encrypter $encrypter,
    ) {
    }

    /**
     * Keeps only the expected fields, cleaned. Anything else sent by the client is ignored.
     */
    public function normalize(array $input): array
    {
        return [
            'category' => clean_text($input['category'] ?? '', 30),
            'option' => clean_text($input['option'] ?? '', 60),
            'quantity' => str_replace(',', '.', clean_text($input['quantity'] ?? '', 20)),
            'note' => clean_text($input['note'] ?? '', 1000, multiline: true),
            'name' => clean_text($input['name'] ?? '', 100),
            'phone' => clean_text($input['phone'] ?? '', 20),
            'email' => mb_strtolower(clean_text($input['email'] ?? '', 254)),
            'consent' => filter_var($input['consent'] ?? false, FILTER_VALIDATE_BOOL),
        ];
    }

    /**
     * @return array<string, string> field name => error message
     */
    public function validate(array $data): array
    {
        $errors = [];
        $category = $this->company->estimationCategory($data['category']);

        if ($category === null) {
            $errors['category'] = 'Choisissez ce que vous souhaitez vendre.';
        } elseif (!in_array($data['option'], $category['options'], true)) {
            $errors['option'] = 'Précisez : ' . mb_strtolower($category['option_label']) . '.';
        }

        if ($data['quantity'] !== '' && (!is_numeric($data['quantity']) || (float) $data['quantity'] <= 0 || (float) $data['quantity'] > 1_000_000)) {
            $errors['quantity'] = 'Indiquez un nombre positif.';
        }

        if ($data['name'] === '') {
            $errors['name'] = 'Indiquez votre nom.';
        }

        if (!preg_match(self::PHONE_PATTERN, $data['phone'])) {
            $errors['phone'] = 'Indiquez un numéro de téléphone français valide.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Indiquez une adresse e-mail valide.';
        }

        if ($data['consent'] !== true) {
            $errors['consent'] = 'Votre accord est nécessaire pour être recontacté.';
        }

        return $errors;
    }

    public function create(array $data): array
    {
        $category = $this->company->estimationCategory($data['category']);

        $estimation = [
            'reference' => 'EST-' . strtoupper(bin2hex(random_bytes(4))),
            'created_at' => date(DATE_ATOM),
            'category' => $category['id'],
            'category_label' => $category['label'],
            'option' => $data['option'],
            'quantity' => $data['quantity'] === '' ? null : (float) $data['quantity'],
            'quantity_unit' => $category['quantity_unit'] ?? '',
            'consent_at' => date(DATE_ATOM),
        ];

        foreach (self::PERSONAL_FIELDS as $field) {
            $estimation[$field] = $this->encrypter->encrypt($data[$field]);
        }

        $all = $this->storage->has(self::FILE) ? $this->storage->read(self::FILE) : [];
        array_unshift($all, $estimation);
        $this->storage->write(self::FILE, $all);

        return $estimation;
    }

    public function latest(int $limit): array
    {
        $records = $this->storage->has(self::FILE) ? $this->storage->read(self::FILE) : [];

        return array_map(function (array $estimation): array {
            foreach (self::PERSONAL_FIELDS as $field) {
                $estimation[$field] = $this->encrypter->decrypt((string) ($estimation[$field] ?? ''));
            }

            return $estimation + ['created_label' => format_datetime($estimation['created_at'])];
        }, array_slice($records, 0, $limit));
    }
}
