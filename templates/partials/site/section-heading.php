<header class="section-heading<?= !empty($center) ? ' section-heading--center' : '' ?>">
    <p class="eyebrow"><?= e($eyebrow) ?></p>
    <h2 class="section-heading__title"><?= with_accent($title, $accent ?? '') ?></h2>
    <?php if (!empty($lead)): ?>
        <p class="section-heading__lead"><?= e($lead) ?></p>
    <?php endif ?>
</header>
