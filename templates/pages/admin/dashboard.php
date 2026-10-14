<div class="dashboard" data-dashboard data-stats-endpoint="<?= e(url('api/stats')) ?>">
    <div class="dashboard__row">
        <section class="card card--dark">
            <header class="card__header">
                <div>
                    <p class="eyebrow eyebrow--light">Vue d'ensemble</p>
                    <h2 class="card__title card__title--light">Volume de rachat</h2>
                </div>
                <div class="segmented" role="group" aria-label="Période" data-period-toggle>
                    <button class="segmented__item is-active" type="button" data-period="month" aria-pressed="true">Mois</button>
                    <button class="segmented__item" type="button" data-period="week" aria-pressed="false">Semaine</button>
                </div>
            </header>
            <div class="card__body">
                <div class="chart" data-chart-state="loading">
                    <canvas id="volume-chart" role="img" aria-label="Volume de rachat en euros"></canvas>
                </div>
            </div>
        </section>

        <section class="card">
            <header class="card__header">
                <div>
                    <p class="eyebrow">Performance</p>
                    <h2 class="card__title">Transactions par mois</h2>
                </div>
            </header>
            <div class="card__body">
                <div class="chart" data-chart-state="loading">
                    <canvas id="transactions-chart" role="img" aria-label="Nombre de transactions par mois"></canvas>
                </div>
            </div>
        </section>
    </div>

    <div class="dashboard__row">
        <section class="card">
            <header class="card__header">
                <h2 class="card__title">Prochaines tournées</h2>
            </header>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Ville</th>
                            <th scope="col">Lieu</th>
                            <th scope="col">Date</th>
                            <th scope="col">Acheteur</th>
                            <th scope="col">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tours as $tour): ?>
                            <tr>
                                <th scope="row"><?= e($tour['city']) ?></th>
                                <td><?= e($tour['venue']) ?></td>
                                <td><?= e($tour['date_label']) ?></td>
                                <td><?= e($tour['buyer']) ?></td>
                                <td>
                                    <span class="status">
                                        <span class="status__dot status__dot--<?= e($tour['status_tone']) ?>"></span>
                                        <?= e($tour['status_label']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card">
            <header class="card__header">
                <h2 class="card__title">Demandes par canal</h2>
            </header>
            <div class="table-wrap">
                <table class="table table--compact">
                    <thead>
                        <tr>
                            <th scope="col">Canal</th>
                            <th scope="col">Demandes</th>
                            <th scope="col">Part</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <th scope="row"><?= e($request['channel']) ?></th>
                                <td><?= e(format_number($request['count'])) ?></td>
                                <td>
                                    <div class="progress-row">
                                        <span class="progress-row__value"><?= e($request['share']) ?>&nbsp;%</span>
                                        <div class="progress" role="progressbar" aria-valuenow="<?= e($request['share']) ?>" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress__bar bg-<?= e($request['tone']) ?>" data-progress="<?= e($request['share']) ?>"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <section class="card">
        <header class="card__header">
            <div>
                <p class="eyebrow">Site web</p>
                <h2 class="card__title">Dernières demandes d'estimation</h2>
            </div>
        </header>
        <?php if ($estimations === []): ?>
            <p class="empty-state">
                Aucune demande pour le moment. Envoyez-en une depuis le
                <a href="<?= e(url('/#estimation')) ?>">formulaire du site</a> : elle apparaîtra ici.
            </p>
        <?php else: ?>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Référence</th>
                            <th scope="col">Reçue le</th>
                            <th scope="col">Client</th>
                            <th scope="col">Objet</th>
                            <th scope="col">Détail</th>
                            <th scope="col">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estimations as $estimation): ?>
                            <tr>
                                <th scope="row"><?= e($estimation['reference']) ?></th>
                                <td><?= e($estimation['created_label']) ?></td>
                                <td><?= e($estimation['name']) ?></td>
                                <td><?= e($estimation['category_label']) ?></td>
                                <td>
                                    <?= e($estimation['option']) ?>
                                    <?php if ($estimation['quantity'] !== null): ?>
                                        <span class="text-muted">· <?= e(trim(format_number($estimation['quantity'], 2) . ' ' . $estimation['quantity_unit'])) ?></span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <a href="tel:<?= e(preg_replace('/\s+/', '', $estimation['phone'])) ?>"><?= e($estimation['phone']) ?></a><br>
                                    <a class="text-muted" href="mailto:<?= e($estimation['email']) ?>"><?= e($estimation['email']) ?></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </section>
</div>
