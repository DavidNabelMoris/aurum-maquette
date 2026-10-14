<section class="section section--raised" id="rachat">
    <div class="container">
        <?php partial('site/section-heading', [
            'eyebrow' => 'Ce que nous rachetons',
            'title' => "Bien plus que de l'or",
            'accent' => "que de l'or",
            'lead' => 'Estimation gratuite, sans obligation de vente. Le prix est indexé sur le cours des métaux précieux.',
        ]) ?>

        <ul class="category-grid">
            <?php foreach ($categories as $category): ?>
                <li class="category-card">
                    <span class="category-card__icon"><i data-lucide="<?= e($category['icon']) ?>"></i></span>
                    <h3 class="category-card__title"><?= e($category['title']) ?></h3>
                    <ul class="category-card__details">
                        <?php foreach ($category['details'] as $detail): ?>
                            <li><?= e($detail) ?></li>
                        <?php endforeach ?>
                    </ul>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</section>
