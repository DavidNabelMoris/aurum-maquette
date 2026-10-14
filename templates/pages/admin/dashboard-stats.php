<div class="stats-grid">
    <?php foreach ($kpis as $kpi): ?>
        <?php partial('admin/stat-card', ['kpi' => $kpi]) ?>
    <?php endforeach ?>
</div>
