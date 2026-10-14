<section class="error-page">
    <div class="container">
        <p class="error-page__code">404</p>
        <h1 class="error-page__title">Cette page <span class="accent">n'existe pas.</span></h1>
        <p class="error-page__text">Le lien est peut-être ancien ou mal copié. Voici où aller ensuite :</p>
        <div class="error-page__actions">
            <a class="btn btn--solid" href="<?= e(url('/')) ?>">Retour à l'accueil <i data-lucide="arrow-right"></i></a>
            <a class="btn btn--text" href="<?= e(url('/#estimation')) ?>">Demander une estimation</a>
            <a class="btn btn--text" href="<?= e(url('/#agences')) ?>">Trouver une agence</a>
        </div>
    </div>
</section>
