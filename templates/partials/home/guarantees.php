<section class="guarantees" aria-label="Nos engagements">
    <ul class="guarantees__list container">
        <?php foreach ($guarantees as $guarantee): ?>
            <li class="guarantee">
                <span class="guarantee__icon"><i data-lucide="<?= e($guarantee['icon']) ?>"></i></span>
                <div>
                    <h3 class="guarantee__title"><?= e($guarantee['title']) ?></h3>
                    <p class="guarantee__text"><?= e($guarantee['text']) ?></p>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
</section>
