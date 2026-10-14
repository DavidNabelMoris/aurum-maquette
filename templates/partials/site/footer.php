<?php $contact = config('app.contact'); ?>
<footer class="site-footer">
    <div class="container site-footer__grid">
        <div class="site-footer__about">
            <?php partial('brand', ['href' => url('/')]) ?>
            <p>Rachat d'or et d'argent, bijoux et objets de valeur, change de devises. Depuis <?= e($profile['founded']) ?>, siège à <?= e($profile['headquarters']) ?>.</p>
            <ul class="site-footer__badges">
                <?php foreach ($profile['regulation'] as $item): ?>
                    <li><i data-lucide="shield-check"></i> <?= e($item) ?></li>
                <?php endforeach ?>
            </ul>
        </div>

        <nav aria-label="Services">
            <h2 class="site-footer__title">Services</h2>
            <ul class="site-footer__links">
                <?php foreach (config('app.site_nav') as $link): ?>
                    <li><a href="<?= e(url($link['href'])) ?>"><?= e($link['label']) ?></a></li>
                <?php endforeach ?>
                <li><a href="<?= e(url('/#estimation')) ?>">Estimation gratuite</a></li>
            </ul>
        </nav>

        <nav aria-label="Informations">
            <h2 class="site-footer__title">Informations</h2>
            <ul class="site-footer__links">
                <?php foreach (config('app.legal_nav') as $link): ?>
                    <li><a href="<?= e(url($link['href'])) ?>"><?= e($link['label']) ?></a></li>
                <?php endforeach ?>
                <li><button class="site-footer__button" type="button" data-cookie-settings>Gérer les cookies</button></li>
            </ul>
        </nav>

        <address class="site-footer__contact">
            <h2 class="site-footer__title">Service client</h2>
            <a class="site-footer__phone" href="tel:<?= e(str_replace(' ', '', $profile['phone'])) ?>"><?= e($profile['phone']) ?></a>
            <ul class="site-footer__hours">
                <?php foreach ($profile['hours'] as $slot): ?>
                    <li><?= e($slot['days']) ?> : <?= e($slot['time']) ?></li>
                <?php endforeach ?>
            </ul>
            <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a>
            <?php if ($contact['address']): ?>
                <p><?= e($contact['address']) ?></p>
            <?php endif ?>
            <p><?= e($agencyCount) ?> agences en France</p>
        </address>
    </div>

    <div class="container site-footer__bottom">
        <p>© <?= date('Y') ?> <?= e(config('app.name')) ?> · <?= e(config('app.label')) ?> réalisée par David N.M, données de démonstration.</p>
        <a href="<?= e(url('admin')) ?>">Espace pro</a>
    </div>
</footer>
