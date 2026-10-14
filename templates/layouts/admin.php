<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title) ?> · Espace pro · <?= e(config('app.name')) ?></title>
    <link rel="icon" href="<?= e(url('favicon.svg')) ?>" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="<?= asset('css/base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="admin">
    <?php partial('admin/sidebar', ['active' => $active]) ?>
    <div class="sidebar-backdrop" data-sidebar-backdrop hidden></div>

    <div class="admin-main">
        <header class="admin-header">
            <?php partial('admin/topbar', ['title' => $title, 'user' => $user, 'csrfField' => $csrfField]) ?>
            <div class="admin-container"><?= $header ?? '' ?></div>
        </header>

        <main class="admin-content admin-container"><?= $content ?></main>

        <?php partial('admin/footer') ?>
    </div>

    <?= vendor_script('lucide') ?>
    <?php foreach ($vendors ?? [] as $vendor): ?>
        <?= vendor_script($vendor) ?>
    <?php endforeach ?>
    <?php foreach ($scripts ?? [] as $script): ?>
        <script type="module" src="<?= asset($script) ?>"></script>
    <?php endforeach ?>
</body>
</html>
