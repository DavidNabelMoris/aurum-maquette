<?php
$chart = sparkline($gold['history']);
$goldIsUp = $gold['change_pct'] >= 0;
?>
<div class="price-panel">
    <div class="price-panel__bar" aria-hidden="true">
        <span class="price-panel__dot"></span>
        <span class="price-panel__dot"></span>
        <span class="price-panel__dot"></span>
        <span class="price-panel__address">Cours des métaux précieux</span>
    </div>

    <div class="price-panel__body">
        <div class="price-panel__main">
            <p class="price-panel__eyebrow">Cours de l'or</p>
            <p class="price-panel__value">
                <?= e(format_currency($gold['eur_per_oz'])) ?>
                <span class="price-panel__unit">/ once</span>
            </p>
            <p class="change change--<?= $goldIsUp ? 'up' : 'down' ?>">
                <?= e(format_percent($gold['change_pct'], true)) ?> aujourd'hui
            </p>

            <svg class="sparkline" viewBox="<?= e($chart['viewBox']) ?>" preserveAspectRatio="none" role="img" aria-label="Évolution du cours de l'or sur 14 jours">
                <defs>
                    <linearGradient id="sparkline-fill" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="currentColor" stop-opacity="0.35"/>
                        <stop offset="100%" stop-color="currentColor" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path class="sparkline__area" d="<?= e($chart['area']) ?>"/>
                <path class="sparkline__line" d="<?= e($chart['line']) ?>"/>
            </svg>
        </div>

        <ul class="price-panel__list">
            <?php foreach ($metals as $metal): ?>
                <li class="price-panel__item">
                    <span class="price-panel__name"><?= e($metal['name']) ?></span>
                    <span class="price-panel__price"><?= e(format_currency($metal['eur_per_kg'])) ?> <small>/ kg</small></span>
                    <span class="change change--<?= $metal['change_pct'] >= 0 ? 'up' : 'down' ?>">
                        <?= e(format_percent($metal['change_pct'], true)) ?>
                    </span>
                </li>
            <?php endforeach ?>
        </ul>
    </div>

    <p class="price-panel__note"><?= e($source) ?> · mis à jour le <?= e(format_datetime($updatedAt)) ?></p>
</div>
