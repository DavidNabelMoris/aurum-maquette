<?php partial('site/page-header', ['eyebrow' => 'Informations', 'title' => 'Mentions légales']) ?>

<section class="section section--tight">
    <div class="container prose">
        <?php partial('site/draft-notice') ?>

        <h2>Éditeur du site</h2>
        <p>
            [Raison sociale], [forme juridique] au capital de [montant] €<br>
            Siège social : [adresse], Lyon<br>
            RCS Lyon [numéro] · SIREN [numéro] · TVA intracommunautaire [numéro]<br>
            Téléphone : <?= e($profile['phone']) ?> · E-mail : <?= e(config('app.contact.email')) ?>
        </p>
        <p>Directeur de la publication : [nom].</p>

        <h2>Activité réglementée</h2>
        <p>
            Changeur manuel autorisé par l'Autorité de contrôle prudentiel et de résolution (ACPR), 4 place de Budapest,
            75436 Paris Cedex 09. Numéro d'autorisation : [numéro].
        </p>

        <h2>Hébergement</h2>
        <p>[Nom de l'hébergeur], [adresse], [téléphone].</p>

        <h2>Propriété intellectuelle</h2>
        <p>
            L'ensemble des contenus de ce site (textes, images, logos) est protégé par le droit d'auteur.
            Toute reproduction sans autorisation écrite est interdite.
        </p>

        <h2>Données personnelles</h2>
        <p>
            Le traitement de vos données est décrit dans notre
            <a href="<?= e(url('confidentialite')) ?>">politique de confidentialité</a>.
        </p>
    </div>
</section>
