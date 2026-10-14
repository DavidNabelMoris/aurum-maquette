<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Service indisponible · <?= e(config('app.name')) ?></title>
    <link rel="stylesheet" href="<?= asset('css/base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/site.css') ?>">
</head>
<body class="site">
    <main class="error-page">
        <div class="container">
            <p class="error-page__code">500</p>
            <h1 class="error-page__title">Un incident <span class="accent">est en cours.</span></h1>
            <p class="error-page__text">Le service est momentanément indisponible. Réessayez dans quelques minutes.</p>
            <div class="error-page__actions">
                <a class="btn btn--solid" href="<?= e(url('/')) ?>">Retour à l'accueil</a>
            </div>
        </div>
    </main>
</body>
</html>
