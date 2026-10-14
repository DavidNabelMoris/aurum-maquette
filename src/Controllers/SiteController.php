<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Security\Csrf;
use App\Security\Session;
use App\Services\AgencyService;
use App\Services\CompanyService;
use App\Services\MetalPriceService;
use App\Services\TourService;

final class SiteController
{
    public const FORM_RENDERED_AT = 'estimation_form_rendered_at';

    private CompanyService $company;
    private MetalPriceService $prices;
    private AgencyService $agencies;

    public function __construct()
    {
        $this->company = new CompanyService(data_store());
        $this->prices = new MetalPriceService(data_store());
        $this->agencies = new AgencyService(data_store());
    }

    public function home(): void
    {
        Session::put(self::FORM_RENDERED_AT, time());

        $this->page('pages/home', [
            'meta' => [
                'title' => "Rachat d'or et d'argent, change de devises",
                'description' => "Rachat d'or et d'argent, bijoux, pièces, lingots, montres et sacs de luxe. Estimation gratuite en agence, à domicile, en tournée ou par kit postal.",
                'path' => '/',
            ],
            'structuredData' => $this->organizationSchema(),
            'scripts' => ['js/pages/home.js'],
            'csrfToken' => Csrf::token(),
            'guarantees' => $this->company->guarantees(),
            'categories' => $this->company->purchaseCategories(),
            'channels' => $this->company->channels(),
            'exchange' => $this->company->exchange(),
            'investment' => $this->company->investment(),
            'estimationCategories' => $this->company->estimationCategories(),
            'agencies' => $this->agencies->all(),
            'regions' => $this->agencies->regions(),
            'tours' => (new TourService(data_store()))->confirmed(6),
            'priceSource' => $this->prices->source(),
            'pricesUpdatedAt' => $this->prices->updatedAt(),
        ]);
    }

    public function about(): void
    {
        $this->page('pages/about', [
            'meta' => [
                'title' => 'À propos',
                'description' => "Depuis 2011, rachat d'or et d'argent, change de devises et tournées dans toute la France. Notre histoire et nos engagements.",
                'path' => '/a-propos',
            ],
            'channels' => $this->company->channels(),
            'guarantees' => $this->company->guarantees(),
        ]);
    }

    public function legalNotice(): void
    {
        $this->page('pages/legal/notice', [
            'meta' => ['title' => 'Mentions légales', 'description' => 'Mentions légales du site.', 'path' => '/mentions-legales'],
        ]);
    }

    public function privacy(): void
    {
        $this->page('pages/legal/privacy', [
            'meta' => ['title' => 'Politique de confidentialité', 'description' => 'Comment nous collectons, utilisons et protégeons vos données personnelles.', 'path' => '/confidentialite'],
        ]);
    }

    public function terms(): void
    {
        $this->page('pages/legal/terms', [
            'meta' => ['title' => "Conditions d'utilisation", 'description' => "Conditions d'utilisation du site et du service d'estimation.", 'path' => '/cgu'],
        ]);
    }

    public function notFound(): void
    {
        $this->page('pages/errors/not-found', [
            'meta' => ['title' => 'Page introuvable', 'description' => 'Cette page n\'existe pas.', 'path' => request_path(), 'noindex' => true],
        ], status: 404);
    }

    private function page(string $template, array $data, int $status = 200): void
    {
        view($template, $data + [
            'profile' => $this->company->profile(),
            'metals' => $this->prices->all(),
            'gold' => $this->prices->find('gold'),
            'agencyCount' => $this->agencies->count(),
            'scripts' => ['js/pages/site.js'],
        ], 'site', $status);
    }

    private function organizationSchema(): array
    {
        $profile = $this->company->profile();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => absolute_url('/'),
            'logo' => absolute_url('favicon.svg'),
            'foundingDate' => (string) $profile['founded'],
            'areaServed' => 'FR',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+33 ' . ltrim($profile['phone'], '0'),
                'contactType' => 'customer service',
                'availableLanguage' => 'French',
                'hoursAvailable' => [
                    ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday'], 'opens' => '09:30', 'closes' => '19:00'],
                    ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Friday', 'opens' => '09:30', 'closes' => '18:00'],
                ],
            ],
        ];
    }
}
