<?php
$pageTitle = $meta['path'] === '/' ? config('app.name') . ' · ' . $meta['title'] : $meta['title'] . ' · ' . config('app.name');
$canonical = absolute_url($meta['path']);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($meta['description']) ?>">
    <?php if (!empty($meta['noindex']) || config('app.demo')): ?>
        <meta name="robots" content="noindex">
    <?php else: ?>
        <link rel="canonical" href="<?= e($canonical) ?>">
    <?php endif ?>
    <meta name="theme-color" content="#111110">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="<?= e(config('app.name')) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($meta['description']) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e(absolute_url('assets/img/og-image.jpg')) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="<?= e(url('favicon.svg')) ?>" type="image/svg+xml">
    <link rel="icon" href="<?= e(url('favicon-32.png')) ?>" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="<?= e(url('apple-touch-icon.png')) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600&family=Instrument+Serif:ital@0;1&display=swap">
    <?php if ($meta['path'] === '/'): ?>
        <link rel="preload" as="image" href="<?= asset('img/sculpture/sculpture.webp') ?>" media="(min-width: 640px)">
    <?php endif ?>
    <link rel="stylesheet" href="<?= asset('css/base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/site.css') ?>">

    <?php if (!empty($structuredData)): ?>
        <script type="application/ld+json"><?= json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
    <?php endif ?>
</head>
<body class="site" data-gtm-id="<?= e(config('app.analytics.gtm_id') ?? '') ?>">
    <a class="skip-link" href="#contenu">Aller au contenu</a>

    <?php partial('site/header', ['metals' => $metals, 'gold' => $gold]) ?>

    <main id="contenu"><?= $content ?></main>

    <?php partial('site/footer', ['profile' => $profile, 'agencyCount' => $agencyCount]) ?>
    <?php partial('site/sticky-cta', ['profile' => $profile]) ?>
    <?php partial('site/cookie-banner') ?>

    <?= vendor_script('lucide') ?>
    <?php foreach ($scripts as $script): ?>
        <script type="module" src="<?= asset($script) ?>"></script>
    <?php endforeach ?>
</body>
</html>
