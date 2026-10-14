<div class="topbar admin-container">
    <div class="topbar__start">
        <button class="topbar__menu" type="button" aria-label="Ouvrir la navigation" aria-expanded="false" aria-controls="sidebar" data-sidebar-open>
            <i data-lucide="menu"></i>
        </button>
        <h1 class="topbar__title"><?= e($title) ?></h1>
    </div>

    <div class="topbar__end">
        <div class="topbar__user">
            <span class="avatar" aria-hidden="true"><?= e(mb_strtoupper(mb_substr($user, 0, 2))) ?></span>
            <span class="topbar__user-name"><?= e($user) ?></span>
        </div>

        <form method="post" action="<?= e(url('admin/logout')) ?>">
            <?= $csrfField ?>
            <button class="topbar__logout" type="submit" aria-label="Se déconnecter" title="Se déconnecter">
                <i data-lucide="log-out"></i>
            </button>
        </form>
    </div>
</div>
