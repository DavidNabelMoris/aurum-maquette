<?php partial('site/page-header', ['eyebrow' => 'Informations', 'title' => 'Politique de confidentialité']) ?>

<section class="section section--tight">
    <div class="container prose">
        <?php partial('site/draft-notice') ?>

        <h2>Responsable du traitement</h2>
        <p>[Raison sociale], [adresse], Lyon. Contact : <?= e(config('app.contact.email')) ?>.</p>

        <h2>Données collectées</h2>
        <p>Lorsque vous demandez une estimation, nous collectons :</p>
        <ul>
            <li>votre nom, votre numéro de téléphone et votre adresse e-mail ;</li>
            <li>la description des objets que vous souhaitez vendre (type, titre, poids ou montant, commentaire) ;</li>
            <li>la date de votre demande et de votre consentement.</li>
        </ul>
        <p>Nous ne collectons aucune donnée bancaire sur ce site.</p>

        <h2>Finalité et base légale</h2>
        <p>
            Ces données servent uniquement à vous recontacter pour établir une estimation. Le traitement repose sur votre
            consentement, donné en cochant la case du formulaire, et sur les mesures précontractuelles prises à votre demande.
        </p>

        <h2>Durée de conservation</h2>
        <p>
            Vos données sont conservées 3 ans à compter de notre dernier contact, puis supprimées. Les obligations légales
            liées aux transactions (lutte contre le blanchiment) peuvent imposer une durée plus longue en cas de vente.
        </p>

        <h2>Sécurité</h2>
        <p>
            Vos coordonnées sont chiffrées sur nos serveurs et accessibles uniquement aux conseillers habilités.
            Le site applique les protections recommandées (connexion chiffrée, en-têtes de sécurité, limitation des envois).
        </p>

        <h2>Vos droits</h2>
        <p>
            Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation et d'opposition, ainsi que du droit
            de retirer votre consentement. Écrivez-nous à <?= e(config('app.contact.email')) ?>. Vous pouvez aussi adresser
            une réclamation à la CNIL (cnil.fr).
        </p>

        <h2 id="cookies">Cookies</h2>
        <p>
            Le site utilise un cookie de session strictement nécessaire (sécurité du formulaire). Les cookies de mesure
            d'audience ne sont déposés qu'avec votre accord, que vous pouvez modifier à tout moment.
        </p>
        <p><button class="btn btn--outline" type="button" data-cookie-settings>Gérer mes cookies</button></p>
    </div>
</section>
