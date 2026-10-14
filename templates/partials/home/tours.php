<section class="section section--raised" id="tournees">
    <div class="container">
        <div class="section-row">
            <?php partial('site/section-heading', [
                'eyebrow' => 'Tournées',
                'title' => 'Nos acheteurs près de chez vous',
                'accent' => 'près de chez vous',
                'lead' => "Toute l'année, nos acheteurs installent un comptoir temporaire dans des hôtels, bars, restaurants et bureaux de tabac. Venez avec vos objets et une pièce d'identité.",
            ]) ?>
            <p class="badge"><i data-lucide="map"></i> Carte interactive bientôt disponible</p>
        </div>

        <?php if ($tours === []): ?>
            <p class="empty-state">
                Aucune tournée n'est programmée pour le moment. Appelez-nous ou
                <a href="#estimation">laissez-nous vos coordonnées</a> pour être prévenu des prochaines dates.
            </p>
        <?php endif ?>

        <ul class="tour-list">
            <?php foreach ($tours as $tour): ?>
                <li class="tour">
                    <p class="tour__date">
                        <span class="tour__day"><?= e($tour['day']) ?></span>
                        <span class="tour__month"><?= e($tour['month']) ?></span>
                    </p>
                    <div class="tour__body">
                        <h3 class="tour__city"><?= e($tour['city']) ?> <span>(<?= e($tour['department']) ?>)</span></h3>
                        <p class="tour__venue"><?= e($tour['venue']) ?> · <?= e($tour['venue_type']) ?></p>
                    </div>
                    <p class="tour__hours"><i data-lucide="clock"></i> <?= e($tour['hours']) ?></p>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</section>
