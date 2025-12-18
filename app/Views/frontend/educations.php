<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<section class="theme-shell section-gap" data-animate>
    <div class="surface-elevated p-8 space-y-3">
        <span class="eyebrow"><?= esc(lang('App.education_section_title')) ?></span>
        <h1 class="u-text-primary text-[36px] font-semibold"><?= esc(lang('App.education_section_heading')) ?></h1>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <div class="surface-card p-6 space-y-4">
        <form class="space-y-4" method="get">
            <div class="grid gap-4 lg:grid-cols-4">
                <div class="form-field">
                    <label><?= esc(lang('App.education_filter_label')) ?></label>
                    <input name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>" placeholder="<?= esc(lang('App.education_filter_label')) ?>">
                </div>
                <div class="form-field">
                    <label><?= esc(lang('App.education_level_label')) ?></label>
                    <select name="level">
                        <option value=""><?= esc(lang('App.education_level_all')) ?></option>
                        <?php foreach (['SD', 'SMP', 'SMA', 'Kuliah'] as $level): ?>
                            <option value="<?= esc($level) ?>" <?= ($filters['level'] ?? '') === $level ? 'selected' : '' ?>><?= esc($level) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label><?= esc(lang('App.filter_sort_label')) ?></label>
                    <select name="sort">
                        <option value="desc" <?= ($filters['sort'] ?? 'desc') === 'desc' ? 'selected' : '' ?>><?= esc(lang('App.filter_sort_latest')) ?></option>
                        <option value="asc" <?= ($filters['sort'] ?? '') === 'asc' ? 'selected' : '' ?>><?= esc(lang('App.filter_sort_oldest')) ?></option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="btn-primary-brand inline-flex items-center gap-2" type="submit">
                        <i data-lucide="sliders" class="h-4 w-4"></i>
                        <?= esc(lang('App.education_filter_button')) ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <?php if (! empty($educations)): ?>
        <div class="space-y-4">
            <?php foreach ($educations as $education): ?>
                <article class="surface-card p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="u-text-primary text-lg font-semibold"><?= esc($education['institution']) ?></h3>
                            <p class="u-text-secondary text-sm"><?= esc($education['level']) ?> &middot; <?= esc($education['major'] ?? '-') ?></p>
                        </div>
                        <span class="u-text-muted text-sm"><?= esc($education['start_year']) ?> - <?= esc($education['end_year']) ?></span>
                    </div>
                    <p class="u-text-secondary text-sm leading-relaxed mt-3"><?= esc($education['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="surface-elevated p-6 text-center u-text-secondary">
            <?= esc(lang('App.education_empty')) ?>
        </div>
    <?php endif; ?>
    <div class="mt-6 flex justify-center">
        <?= $pager->links('educations', 'default_full', ['params' => $queryParams]) ?>
    </div>
    <div class="flex flex-wrap gap-3 mt-6">
        <a class="btn-ghost" href="<?= site_url('/') ?>"><?= esc(lang('App.back_home')) ?></a>
        <a class="btn-ghost" href="<?= site_url('aktivitas') ?>"><?= esc(lang('App.activities_title')) ?></a>
        <a class="btn-ghost" href="<?= site_url('biodata') ?>"><?= esc(lang('App.cv_section_title')) ?></a>
    </div>
</section>
<?= $this->endSection() ?>
