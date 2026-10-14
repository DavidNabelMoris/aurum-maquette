<?php $isUp = $kpi['change'] >= 0; ?>
<article class="card stat-card">
    <div class="stat-card__body">
        <div>
            <h2 class="stat-card__label"><?= e($kpi['label']) ?></h2>
            <p class="stat-card__value"><?= e($kpi['display']) ?></p>
        </div>
        <span class="icon-shape icon-shape--<?= e($kpi['tone']) ?>">
            <i data-lucide="<?= e($kpi['icon']) ?>"></i>
        </span>
    </div>

    <p class="stat-card__trend">
        <span class="trend trend--<?= $isUp ? 'up' : 'down' ?>">
            <i data-lucide="<?= $isUp ? 'arrow-up' : 'arrow-down' ?>"></i>
            <?= e(format_percent(abs($kpi['change']), decimals: 1)) ?>
        </span>
        <span><?= e($kpi['period']) ?></span>
    </p>
</article>
