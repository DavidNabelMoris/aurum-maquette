<section class="section" id="vendre">
    <div class="container">
        <?php partial('site/section-heading', [
            'eyebrow' => 'Comment vendre',
            'title' => 'Quatre façons de vendre, une seule expertise',
            'accent' => 'une seule expertise',
        ]) ?>

        <div class="channels" data-tabs>
            <div class="channels__tabs" role="tablist" aria-label="Façons de vendre">
                <?php foreach ($channels as $index => $channel): ?>
                    <button class="channels__tab" type="button" role="tab"
                        id="tab-<?= e($channel['id']) ?>"
                        aria-controls="panel-<?= e($channel['id']) ?>"
                        aria-selected="<?= $index === 0 ? 'true' : 'false' ?>"
                        tabindex="<?= $index === 0 ? '0' : '-1' ?>">
                        <i data-lucide="<?= e($channel['icon']) ?>"></i>
                        <span><?= e($channel['label']) ?></span>
                    </button>
                <?php endforeach ?>
            </div>

            <?php foreach ($channels as $index => $channel): ?>
                <div class="channels__panel" role="tabpanel"
                    id="panel-<?= e($channel['id']) ?>"
                    aria-labelledby="tab-<?= e($channel['id']) ?>"
                    <?= $index === 0 ? '' : 'hidden' ?>>
                    <div class="channels__intro">
                        <h3 class="channels__title"><?= e($channel['title']) ?></h3>
                        <p class="channels__text"><?= e($channel['text']) ?></p>
                        <a class="btn btn--solid" href="<?= e($channel['cta']['href']) ?>"><?= e($channel['cta']['label']) ?> <i data-lucide="arrow-right"></i></a>
                    </div>

                    <div>
                        <ol class="steps">
                            <?php foreach ($channel['steps'] as $step): ?>
                                <li class="steps__item"><?= e($step) ?></li>
                            <?php endforeach ?>
                        </ol>
                        <?php if (!empty($channel['note'])): ?>
                            <p class="channels__note"><?= e($channel['note']) ?></p>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
