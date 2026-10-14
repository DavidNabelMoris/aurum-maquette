<section class="hero" data-sculpture-hero
    data-src="<?= e(asset('img/sculpture/sculpture.webp')) ?>"
    data-mobile-src="<?= e(asset('img/sculpture/sculpture-mobile.webp')) ?>">
    <div class="hero__stage" aria-hidden="true">
        <span class="hero__backdrop" data-hero-backdrop>Aurum</span>
        <img class="hero__fallback" src="<?= e(asset('img/sculpture/sculpture.webp')) ?>" alt="" width="1983" height="793" fetchpriority="high" data-hero-fallback>
        <canvas class="hero__canvas" data-hero-canvas></canvas>
    </div>

    <p class="hero__hint" data-hero-hint data-touch-label="Touchez la matière">Passez sur la matière</p>

    <div class="hero__content" data-hero-content>
        <div>
            <p class="eyebrow">Rachat d'or et change · Depuis <?= e($profile['founded']) ?></p>
            <h1 class="hero__title">
                <span class="hero__line">Votre or,</span>
                <span class="hero__line"><span class="accent">estimé au juste cours.</span></span>
            </h1>
        </div>

        <div class="hero__aside">
            <p class="hero__body">
                Bijoux, pièces, lingots, montres et sacs de luxe. Expertise gratuite et sans engagement,
                en agence, à domicile, lors de nos tournées ou par kit postal.
            </p>
            <div class="hero__ctas">
                <a class="btn btn--solid" href="#estimation">Estimer gratuitement <i data-lucide="arrow-right"></i></a>
                <a class="btn btn--text" href="#tournees">Prochaines tournées <i data-lucide="arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>
