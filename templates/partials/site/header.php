<?php
$quotes = [
    ['label' => 'Or', 'value' => format_currency($gold['eur_per_kg']) . ' / kg', 'change' => $gold['change_pct']],
    ['label' => 'Or', 'value' => format_currency($gold['eur_per_oz']) . ' / once', 'change' => $gold['change_pct']],
    ['label' => 'Or', 'value' => format_number($gold['usd_per_oz'], 2) . "\u{00A0}$ / once", 'change' => $gold['change_pct']],
];

foreach ($metals as $metal) {
    if ($metal['id'] !== 'gold') {
        $quotes[] = ['label' => $metal['name'], 'value' => format_currency($metal['eur_per_kg']) . ' / kg', 'change' => $metal['change_pct']];
    }
}
?>
<header class="site-header" data-site-header>
    <div class="ticker" aria-label="Cours des métaux précieux">
        <div class="ticker__track">
            <?php foreach ([false, true] as $isCopy): ?>
                <ul class="ticker__list"<?= $isCopy ? ' aria-hidden="true"' : '' ?>>
                    <?php foreach ($quotes as $quote): ?>
                        <li class="ticker__item">
                            <span class="ticker__label"><?= e($quote['label']) ?></span>
                            <span><?= e($quote['value']) ?></span>
                            <span class="change change--<?= $quote['change'] >= 0 ? 'up' : 'down' ?>"><?= e(format_percent($quote['change'], true)) ?></span>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endforeach ?>
        </div>
    </div>

    <nav class="site-nav" aria-label="Navigation principale">
        <?php partial('brand', ['href' => url('/')]) ?>

        <ul class="site-nav__links">
            <?php foreach (config('app.site_nav') as $link): ?>
                <li><a class="site-nav__link" href="<?= e(url($link['href'])) ?>"><?= e($link['label']) ?></a></li>
            <?php endforeach ?>
        </ul>

        <div class="site-nav__actions">
            <a class="site-nav__link" href="<?= e(url('admin')) ?>">Espace pro</a>
            <a class="btn btn--outline" href="<?= e(url('/#estimation')) ?>">Estimation gratuite</a>
        </div>

        <button class="site-nav__toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
            <span class="site-nav__toggle-icon site-nav__toggle-icon--open"><i data-lucide="menu"></i></span>
            <span class="site-nav__toggle-icon site-nav__toggle-icon--close"><i data-lucide="x"></i></span>
        </button>
    </nav>

    <div class="mobile-menu" id="mobile-menu" hidden>
        <?php foreach (config('app.site_nav') as $link): ?>
            <a class="mobile-menu__link" href="<?= e(url($link['href'])) ?>"><?= e($link['label']) ?></a>
        <?php endforeach ?>
        <div class="mobile-menu__actions">
            <a class="btn btn--solid" href="<?= e(url('/#estimation')) ?>">Estimation gratuite</a>
            <a class="btn btn--outline" href="<?= e(url('admin')) ?>">Espace pro</a>
        </div>
    </div>
</header>
