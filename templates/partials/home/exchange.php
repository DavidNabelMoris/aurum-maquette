<section class="section section--raised" id="change">
    <div class="container">
        <?php partial('site/section-heading', [
            'eyebrow' => 'Change et investissement',
            'title' => 'Changer vos devises, investir dans l\'or',
            'accent' => 'investir dans l\'or',
        ]) ?>

        <div class="duo">
            <article class="feature-card">
                <p class="eyebrow">Bureau de change</p>
                <h3 class="feature-card__title"><?= e($exchange['count']) ?> devises disponibles</h3>
                <p class="feature-card__text">Euros, dollars, livres, yens et bien d'autres, au cours du marché. Changeur manuel autorisé par l'ACPR.</p>
                <ul class="currency-list">
                    <?php foreach ($exchange['currencies'] as $currency): ?>
                        <li class="currency">
                            <span class="currency__symbol"><?= e($currency['symbol']) ?></span>
                            <span class="currency__label"><?= e($currency['label']) ?></span>
                        </li>
                    <?php endforeach ?>
                </ul>
                <a class="btn btn--text" href="#agences">Trouver une agence <i data-lucide="arrow-right"></i></a>
            </article>

            <article class="feature-card">
                <p class="eyebrow">Investir</p>
                <h3 class="feature-card__title">Lingots et pièces d'investissement</h3>
                <p class="feature-card__text">Achetez de l'or physique, livré sous scellé.</p>
                <div class="feature-card__columns">
                    <div>
                        <h4 class="feature-card__subtitle">Lingots</h4>
                        <ul class="check-list">
                            <?php foreach ($investment['bars'] as $item): ?>
                                <li><i data-lucide="check"></i> <?= e($item) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <div>
                        <h4 class="feature-card__subtitle">Pièces</h4>
                        <ul class="check-list">
                            <?php foreach ($investment['coins'] as $item): ?>
                                <li><i data-lucide="check"></i> <?= e($item) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <a class="btn btn--text" href="#estimation">Être rappelé par un conseiller <i data-lucide="arrow-right"></i></a>
            </article>
        </div>
    </div>
</section>
