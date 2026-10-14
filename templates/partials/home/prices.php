<section class="section" id="cours">
    <div class="container split">
        <div>
            <?php partial('site/section-heading', [
                'eyebrow' => 'Cours du jour',
                'title' => 'Un prix indexé sur le marché',
                'accent' => 'indexé sur le marché',
                'lead' => "Nos offres suivent le cours de l'or, de l'argent, du platine et du palladium en temps réel. Vous savez exactement sur quelle base votre estimation est calculée.",
            ]) ?>
            <a class="btn btn--text" href="#estimation">Estimer mes objets <i data-lucide="arrow-right"></i></a>
        </div>

        <div class="price-panel-wrap">
            <div class="price-panel-wrap__glow" aria-hidden="true"></div>
            <?php partial('site/price-panel', [
                'gold' => $gold,
                'metals' => $metals,
                'source' => $priceSource,
                'updatedAt' => $pricesUpdatedAt,
            ]) ?>
        </div>
    </div>
</section>
