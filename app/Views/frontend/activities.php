<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<?php
    $categories = [
        'kerja'   => lang('App.category_kerja'),
        'kuliah'  => lang('App.category_kuliah'),
        'lainnya' => lang('App.category_lainnya'),
    ];
?>
<section class="theme-shell section-gap" data-animate>
    <div class="surface-elevated p-8 space-y-3">
        <span class="eyebrow"><?= esc(lang('App.activities_title')) ?></span>
        <div>
            <h1 class="u-text-primary text-[36px] font-semibold"><?= esc(lang('App.activities_heading')) ?></h1>
            <p class="u-text-secondary text-base"><?= esc(lang('App.activities_hint')) ?></p>
        </div>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <div class="surface-card p-6 space-y-4">
        <form class="space-y-4" method="get">
            <div class="grid gap-4 lg:grid-cols-4">
                <div class="form-field">
                    <label><?= esc(lang('App.filter_search_label')) ?></label>
                    <input name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>" placeholder="<?= esc(lang('App.filter_search_placeholder')) ?>">
                </div>
                <div class="form-field">
                    <label><?= esc(lang('App.filter_category_label')) ?></label>
                    <select name="category">
                        <option value=""><?= esc(lang('App.filter_category_all')) ?></option>
                        <?php foreach ($categories as $key => $label): ?>
                            <option value="<?= esc($key) ?>" <?= ($filters['category'] ?? '') === $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="form-field">
                        <label><?= esc(lang('App.filter_date_label')) ?> (Mulai)</label>
                        <input type="date" name="start_date" value="<?= esc($filters['start_date'] ?? '') ?>">
                    </div>
                    <div class="form-field">
                        <label><?= esc(lang('App.filter_date_label')) ?> (Selesai)</label>
                        <input type="date" name="end_date" value="<?= esc($filters['end_date'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-field">
                    <label><?= esc(lang('App.filter_sort_label')) ?></label>
                    <select name="sort">
                        <option value="desc" <?= ($filters['sort'] ?? 'desc') === 'desc' ? 'selected' : '' ?>><?= esc(lang('App.filter_sort_latest')) ?></option>
                        <option value="asc" <?= ($filters['sort'] ?? '') === 'asc' ? 'selected' : '' ?>><?= esc(lang('App.filter_sort_oldest')) ?></option>
                    </select>
                </div>
            </div>
            <div class="flex flex-wrap justify-between items-center gap-3">
                <p class="u-text-muted text-sm">Menampilkan <?= $rangeStart ?> - <?= $rangeEnd ?> dari <?= $total ?> catatan</p>
                <button class="btn-primary-brand inline-flex items-center gap-2" type="submit">
                    <i data-lucide="filter" class="h-4 w-4"></i>
                    <?= esc(lang('App.filter_apply')) ?>
                </button>
            </div>
        </form>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <?php if (! empty($activities)): ?>
        <div class="space-y-4">
            <?php foreach ($activities as $activity): ?>
                <article class="surface-card p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="u-text-primary text-lg font-semibold"><?= esc($activity['title']) ?></h3>
                            <p class="u-text-secondary text-sm"><?= esc($activity['location']) ?> &middot; <?= esc(date('d M Y', strtotime($activity['activity_date']))) ?></p>
                        </div>
                        <span class="badge-soft"><?= esc($categories[$activity['category']] ?? $activity['category']) ?></span>
                    </div>
                    <p class="u-text-secondary text-sm leading-relaxed mt-3"><?= esc($activity['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="surface-elevated p-6 text-center u-text-secondary">
            <?= esc(lang('App.activity_empty')) ?>
        </div>
    <?php endif; ?>
    <div class="mt-6 flex justify-center">
        <?= $pager->links('activities', 'default_full', ['params' => $queryParams]) ?>
    </div>
</section>
<?= $this->endSection() ?>
