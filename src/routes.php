<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\SeoController;
use App\Controllers\SiteController;
use App\Http\Router;

$router = new Router();

$router->get('/', [SiteController::class, 'home']);
$router->get('/a-propos', [SiteController::class, 'about']);
$router->get('/mentions-legales', [SiteController::class, 'legalNotice']);
$router->get('/confidentialite', [SiteController::class, 'privacy']);
$router->get('/cgu', [SiteController::class, 'terms']);

$router->get('/robots.txt', [SeoController::class, 'robots']);
$router->get('/sitemap.xml', [SeoController::class, 'sitemap']);

$router->get('/admin/login', [AuthController::class, 'showLogin']);
$router->post('/admin/login', [AuthController::class, 'login']);
$router->post('/admin/logout', [AuthController::class, 'logout'], auth: true);
$router->get('/admin', [AdminController::class, 'dashboard'], auth: true);

$router->get('/api/stats', [ApiController::class, 'stats'], auth: true);
$router->post('/api/estimations', [ApiController::class, 'storeEstimation']);

return $router;
