<?php partial('site/page-header', [
    'eyebrow' => 'À propos',
    'title' => "Le rachat d'or, notre métier depuis 2011",
    'accent' => 'depuis 2011',
    'lead' => "Né à Lyon, notre groupe rachète l'or, l'argent et les objets de valeur partout en France, en agence, à domicile, par la poste et lors de nos tournées.",
]) ?>

<section class="section section--tight">
    <div class="container prose-grid">
        <div class="prose">
            <h2>Notre histoire</h2>
            <p>
                Fondé en 2011 à Lyon, notre groupe s'est construit autour des tournées : toute l'année, nos acheteurs
                installent un comptoir temporaire dans des hôtels, bars, restaurants et bureaux de tabac, partout en France.
                Ces tournées restent l'essence même de notre métier.
            </p>
            <p>
                Aujourd'hui, nous vous accueillons aussi dans nos agences, chez vous sur rendez-vous, ou à distance grâce
                à un kit d'estimation gratuit envoyé par la poste. Notre siège est à Lyon.
            </p>

            <h2>Deux activités, un même savoir-faire</h2>
            <p>
                Le rachat d'or et d'argent, mais aussi des bijoux, montres, sacs de luxe, pièces, lingots, diamants et billets
                de collection. Et un bureau de change de plus de 40 devises, en tant que changeur manuel autorisé par l'ACPR et
                agréé Banque de France.
            </p>

            <h2>Comment nous fixons nos prix</h2>
            <p>
                Nos offres sont indexées sur le cours des métaux précieux en temps réel. L'expertise est gratuite, réalisée devant
                vous, et vous restez libre de refuser l'offre.
            </p>
        </div>

        <aside class="facts">
            <dl>
                <div class="facts__item"><dt>Création</dt><dd>2011</dd></div>
                <div class="facts__item"><dt>Siège</dt><dd>Lyon</dd></div>
                <div class="facts__item"><dt>Agences</dt><dd><?= e($agencyCount) ?></dd></div>
                <div class="facts__item"><dt>Devises</dt><dd>40+</dd></div>
            </dl>
        </aside>
    </div>
</section>

<section class="section section--raised section--tight">
    <div class="container">
        <?php partial('site/section-heading', [
            'eyebrow' => 'Nos engagements',
            'title' => 'Ce que nous garantissons',
            'accent' => 'garantissons',
        ]) ?>
        <ul class="guarantee-grid">
            <?php foreach ($guarantees as $guarantee): ?>
                <li class="guarantee">
                    <span class="guarantee__icon"><i data-lucide="<?= e($guarantee['icon']) ?>"></i></span>
                    <div>
                        <h3 class="guarantee__title"><?= e($guarantee['title']) ?></h3>
                        <p class="guarantee__text"><?= e($guarantee['text']) ?></p>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</section>

<section class="section section--tight">
    <div class="container cta-band">
        <h2 class="cta-band__title">Une question, une estimation ? <span class="accent">Parlons-en.</span></h2>
        <div class="cta-band__actions">
            <a class="btn btn--solid" href="<?= e(url('/#estimation')) ?>">Estimer gratuitement <i data-lucide="arrow-right"></i></a>
            <a class="btn btn--text" href="tel:<?= e(str_replace(' ', '', $profile['phone'])) ?>"><?= e($profile['phone']) ?></a>
        </div>
    </div>
</section>
