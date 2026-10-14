<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Security\Csrf;
use App\Security\Encrypter;
use App\Services\CompanyService;
use App\Services\DashboardService;
use App\Services\EstimationService;
use App\Services\TourService;

final class AdminController
{
    public function dashboard(): void
    {
        $dashboard = new DashboardService(data_store());
        $estimations = new EstimationService(storage_store(), new CompanyService(data_store()), new Encrypter());

        $data = [
            'title' => 'Tableau de bord',
            'active' => 'dashboard',
            'user' => auth()->user(),
            'csrfField' => Csrf::field(),
            'vendors' => ['chartjs'],
            'scripts' => ['js/pages/dashboard.js'],
            'kpis' => $dashboard->kpis(),
            'tours' => (new TourService(data_store()))->all(5),
            'requests' => $dashboard->requestsByChannel(),
            'estimations' => $estimations->latest(6),
        ];

        $data['header'] = render('pages/admin/dashboard-stats', $data);

        header('Cache-Control: no-store');
        view('pages/admin/dashboard', $data, 'admin');
    }
}
