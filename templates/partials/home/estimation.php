<section class="section" id="estimation">
    <div class="container split split--form">
        <div>
            <?php partial('site/section-heading', [
                'eyebrow' => 'Estimation gratuite',
                'title' => 'Votre estimation en trois étapes',
                'accent' => 'en trois étapes',
                'lead' => 'Décrivez vos objets, un conseiller vous recontacte avec une première estimation. Gratuit et sans obligation de vente.',
            ]) ?>

            <div class="contact-card">
                <p class="eyebrow">Vous préférez appeler ?</p>
                <a class="contact-card__phone" href="tel:<?= e(str_replace(' ', '', $profile['phone'])) ?>"><?= e($profile['phone']) ?></a>
                <p class="contact-card__label"><?= e($profile['phone_label']) ?></p>
                <ul class="contact-card__hours">
                    <?php foreach ($profile['hours'] as $slot): ?>
                        <li><span><?= e($slot['days']) ?></span><span><?= e($slot['time']) ?></span></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>

        <div class="form-card">
            <form class="estimation-form" action="<?= e(url('api/estimations')) ?>" method="post" novalidate data-estimation-form>
                <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                <ol class="form-progress" aria-hidden="true">
                    <li class="form-progress__step" data-progress-step>Objet</li>
                    <li class="form-progress__step" data-progress-step>Détails</li>
                    <li class="form-progress__step" data-progress-step>Coordonnées</li>
                </ol>

                <fieldset class="form-step" data-step>
                    <legend class="form-step__title">Que souhaitez-vous vendre ?</legend>
                    <div class="choice-grid">
                        <?php foreach ($estimationCategories as $category): ?>
                            <label class="choice">
                                <input type="radio" name="category" value="<?= e($category['id']) ?>" required>
                                <span class="choice__body">
                                    <i data-lucide="<?= e($category['icon']) ?>"></i>
                                    <?= e($category['label']) ?>
                                </span>
                            </label>
                        <?php endforeach ?>
                    </div>
                    <p class="field__error" data-error-for="category"></p>
                    <div class="form-step__actions">
                        <button class="btn btn--solid" type="button" data-next>Continuer <i data-lucide="arrow-right"></i></button>
                    </div>
                </fieldset>

                <fieldset class="form-step" data-step hidden>
                    <legend class="form-step__title">Précisez votre objet</legend>

                    <?php foreach ($estimationCategories as $category): ?>
                        <div class="form-step__group" data-options-for="<?= e($category['id']) ?>" hidden>
                            <p class="field__label"><?= e($category['option_label']) ?></p>
                            <div class="chip-grid">
                                <?php foreach ($category['options'] as $option): ?>
                                    <label class="chip">
                                        <input type="radio" name="option" value="<?= e($option) ?>" required disabled>
                                        <span><?= e($option) ?></span>
                                    </label>
                                <?php endforeach ?>
                            </div>

                            <?php if ($category['quantity_label'] !== null): ?>
                                <label class="field">
                                    <span class="field__label"><?= e($category['quantity_label']) ?> <small>(facultatif)</small></span>
                                    <input class="field__input" type="number" name="quantity" min="0" step="any" inputmode="decimal" disabled>
                                </label>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                    <p class="field__error" data-error-for="option"></p>
                    <p class="field__error" data-error-for="quantity"></p>

                    <label class="field">
                        <span class="field__label">Description <small>(facultatif)</small></span>
                        <textarea class="field__input" name="note" rows="3" maxlength="1000" placeholder="Nombre de pièces, état, marque, poinçons..."></textarea>
                    </label>

                    <div class="form-step__actions">
                        <button class="btn btn--text" type="button" data-prev>Retour</button>
                        <button class="btn btn--solid" type="button" data-next>Continuer <i data-lucide="arrow-right"></i></button>
                    </div>
                </fieldset>

                <fieldset class="form-step" data-step hidden>
                    <legend class="form-step__title">Vos coordonnées</legend>

                    <label class="field">
                        <span class="field__label">Nom et prénom</span>
                        <input class="field__input" type="text" name="name" autocomplete="name" maxlength="100" required>
                        <span class="field__error" data-error-for="name"></span>
                    </label>

                    <div class="field-row">
                        <label class="field">
                            <span class="field__label">Téléphone</span>
                            <input class="field__input" type="tel" name="phone" autocomplete="tel" required>
                            <span class="field__error" data-error-for="phone"></span>
                        </label>
                        <label class="field">
                            <span class="field__label">E-mail</span>
                            <input class="field__input" type="email" name="email" autocomplete="email" required>
                            <span class="field__error" data-error-for="email"></span>
                        </label>
                    </div>

                    <label class="consent">
                        <input type="checkbox" name="consent" value="1" required>
                        <span>J'accepte d'être recontacté au sujet de ma demande d'estimation.</span>
                    </label>
                    <p class="field__error" data-error-for="consent"></p>

                    <input class="honeypot" type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">

                    <div class="form-step__actions">
                        <button class="btn btn--text" type="button" data-prev>Retour</button>
                        <button class="btn btn--solid" type="submit" data-label="Envoyer ma demande">Envoyer ma demande</button>
                    </div>
                    <p class="form-status" role="alert" data-form-status></p>
                </fieldset>
            </form>

            <div class="form-success" tabindex="-1" hidden data-form-success>
                <span class="form-success__icon"><i data-lucide="check"></i></span>
                <h3 class="form-success__title">Demande envoyée</h3>
                <p>Référence <strong data-reference></strong>. Un conseiller vous recontacte rapidement.</p>
            </div>
        </div>
    </div>
</section>
