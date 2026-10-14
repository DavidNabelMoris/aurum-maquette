<section class="section" id="agences">
    <div class="container" data-agency-filter>
        <div class="section-row">
            <?php partial('site/section-heading', [
                'eyebrow' => 'Nos agences',
                'title' => "{$agencyCount} agences en France",
                'accent' => 'en France',
                'lead' => 'Achat et vente d\'or et d\'argent, bijoux, objets de luxe et change de devises. Prenez rendez-vous avec un conseiller spécialisé.',
            ]) ?>
            <p class="agency-count" data-agency-count aria-live="polite"><?= e($agencyCount) ?> agences</p>
        </div>

        <div class="filters" role="group" aria-label="Filtrer par région">
            <button class="filter" type="button" data-filter="all" aria-pressed="true">Toutes</button>
            <?php foreach ($regions as $region): ?>
                <button class="filter" type="button" data-filter="<?= e($region['id']) ?>" aria-pressed="false">
                    <?= e($region['label']) ?> <span class="filter__count"><?= e($region['count']) ?></span>
                </button>
            <?php endforeach ?>
        </div>

        <ul class="agency-grid">
            <?php foreach ($agencies as $agency): ?>
                <li class="agency" data-region="<?= e($agency['region']) ?>">
                    <div>
                        <h3 class="agency__city">
                            <?= e($agency['city']) ?>
                            <?php if ($agency['head_office']): ?><span class="agency__tag">Siège</span><?php endif ?>
                        </h3>
                        <p class="agency__region"><?= e($agency['region_label']) ?> · <?= e($agency['department']) ?></p>
                    </div>
                    <a class="agency__link" href="#estimation" aria-label="Prendre rendez-vous à <?= e($agency['city']) ?>">
                        <i data-lucide="arrow-up-right"></i>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</section>
