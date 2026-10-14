<aside class="sidebar" id="sidebar" data-sidebar>
    <div class="sidebar__brand">
        <?php partial('brand', ['href' => url('admin/')]) ?>
    </div>

    <nav aria-label="Navigation de l'espace pro">
        <ul class="sidebar__nav">
            <?php foreach (config('app.admin_nav') as $item): ?>
                <?php $isActive = $item['id'] === $active; ?>
                <li>
                    <?php if ($item['href'] === null): ?>
                        <span class="sidebar__link is-disabled" aria-disabled="true">
                            <span class="sidebar__icon tone-<?= e($item['tone']) ?>"><i data-lucide="<?= e($item['icon']) ?>"></i></span>
                            <span><?= e($item['label']) ?></span>
                            <span class="pill">Bientôt</span>
                        </span>
                    <?php else: ?>
                        <a class="sidebar__link<?= $isActive ? ' is-active' : '' ?>" href="<?= e(url($item['href'])) ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                            <span class="sidebar__icon tone-<?= e($item['tone']) ?>"><i data-lucide="<?= e($item['icon']) ?>"></i></span>
                            <span><?= e($item['label']) ?></span>
                        </a>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>

        <hr class="sidebar__divider">
        <p class="sidebar__heading">Raccourcis</p>

        <ul class="sidebar__nav">
            <li>
                <a class="sidebar__link" href="<?= e(url('/')) ?>">
                    <span class="sidebar__icon"><i data-lucide="globe"></i></span>
                    <span>Voir le site</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
