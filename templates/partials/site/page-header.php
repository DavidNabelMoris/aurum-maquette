<header class="page-header">
    <div class="container">
        <p class="eyebrow"><?= e($eyebrow) ?></p>
        <h1 class="page-header__title"><?= with_accent($title, $accent ?? '') ?></h1>
        <?php if (!empty($lead)): ?>
            <p class="page-header__lead"><?= e($lead) ?></p>
        <?php endif ?>
    </div>
</header>
