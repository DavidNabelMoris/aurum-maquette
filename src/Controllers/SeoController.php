<?php

declare(strict_types=1);

namespace App\Controllers;

final class SeoController
{
    private const PUBLIC_PAGES = ['/', '/a-propos', '/mentions-legales', '/confidentialite', '/cgu'];

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');

        if (config('app.demo')) {
            echo "User-agent: *\nDisallow: /\n";

            return;
        }

        echo implode("\n", [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /api/',
            '',
            'Sitemap: ' . absolute_url('sitemap.xml'),
            '',
        ]);
    }

    public function sitemap(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $lastModified = date('Y-m-d', filemtime(BASE_PATH . '/data/company.json'));

        echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', "\n";
        foreach (self::PUBLIC_PAGES as $path) {
            printf("  <url><loc>%s</loc><lastmod>%s</lastmod></url>\n", e(absolute_url($path)), $lastModified);
        }
        echo '</urlset>', "\n";
    }
}
