<div class="auth__card card">
    <div class="auth__brand">
        <?php partial('brand', ['href' => url('/')]) ?>
    </div>
    <h1 class="auth__title">Espace pro</h1>
    <p class="auth__subtitle">Connectez-vous pour accéder au tableau de bord.</p>

    <?php if ($error): ?>
        <p class="auth__error" role="alert"><?= e($error) ?></p>
    <?php endif ?>

    <form class="auth__form" method="post" action="<?= e(url('admin/login')) ?>">
        <?= $csrfField ?>
        <label class="auth__field">
            <span>Identifiant</span>
            <input type="text" name="username" value="<?= e($username) ?>" autocomplete="username" required autofocus>
        </label>
        <label class="auth__field">
            <span>Mot de passe</span>
            <input type="password" name="password" autocomplete="current-password" required>
        </label>
        <button class="btn btn--primary auth__submit" type="submit">Se connecter</button>
    </form>

    <a class="auth__back" href="<?= e(url('/')) ?>">← Retour au site</a>
</div>
