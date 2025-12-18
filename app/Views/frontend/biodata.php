<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<?php $profile = $profile ?? null; ?>
<?php
    $cvSkills = $profile['skills'] ?? [];
    if (empty($cvSkills) && ! empty($skills)) {
        $cvSkills = array_map(static fn ($skill) => ['label' => $skill['name'], 'level' => $skill['level']], $skills);
    }
?>
<section class="theme-shell section-gap" data-animate>
    <div class="surface-elevated p-8 space-y-3">
        <span class="eyebrow"><?= esc(lang('App.cv_section_title')) ?></span>
        <div>
            <h1 class="u-text-primary text-[36px] font-semibold"><?= esc($profile['full_name'] ?? lang('App.default_title')) ?></h1>
            <p class="u-text-secondary text-base"><?= esc($profile['job_title'] ?? '') ?></p>
        </div>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <div class="grid gap-8 lg:grid-cols-3">
        <div class="surface-card p-6 space-y-4 text-center">
            <?php if (! empty($profile['photo'])): ?>
                <div class="relative mx-auto h-40 w-40 rounded-full border-4 border-[var(--color-border-subtle)] shadow-card overflow-hidden">
                    <img class="h-full w-full object-cover" src="<?= base_url($profile['photo']) ?>" alt="Foto Profil">
                </div>
            <?php endif; ?>
            <div>
                <h3 class="u-text-primary text-xl font-semibold mb-1"><?= esc($profile['full_name'] ?? '-') ?></h3>
                <p class="u-text-secondary text-sm"><?= esc($profile['job_title'] ?? '-') ?></p>
            </div>
            <div class="space-y-2 text-sm u-text-secondary">
                <p class="flex items-center justify-center gap-2"><i class="bi bi-geo-alt text-lg"></i><span><?= esc($profile['address'] ?? '-') ?></span></p>
                <p class="flex items-center justify-center gap-2"><i class="bi bi-envelope text-lg"></i><span><?= esc($profile['email'] ?? '-') ?></span></p>
                <p class="flex items-center justify-center gap-2"><i class="bi bi-telephone text-lg"></i><span><?= esc($profile['phone'] ?? '-') ?></span></p>
            </div>
            <?php if (! empty($profile['social_links'])): ?>
                <div class="flex flex-wrap justify-center gap-2">
                    <?php foreach ($profile['social_links'] as $social): ?>
                        <a class="btn-ghost text-sm inline-flex items-center gap-2" target="_blank" href="<?= esc($social['url']) ?>">
                            <i class="bi <?= esc($social['icon'] ?? 'bi-link-45deg') ?>"></i><?= esc($social['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (! empty($profile['cv_path'])): ?>
                <?php $cvUrl = str_starts_with($profile['cv_path'], 'http') ? $profile['cv_path'] : base_url($profile['cv_path']); ?>
                <a class="btn-primary-brand inline-flex w-full justify-center items-center gap-2" href="<?= esc($cvUrl) ?>" target="_blank" download>
                    <i class="bi bi-arrow-down-circle"></i><?= esc(lang('App.download_cv')) ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="lg:col-span-2 space-y-6">
            <div class="surface-card p-6">
                <h4 class="u-text-primary text-lg font-semibold mb-3"><?= esc(lang('App.about_label')) ?></h4>
                <div class="u-text-secondary text-sm leading-relaxed">
                    <?= ! empty($profile['short_bio']) ? esc($profile['short_bio'], 'raw') : esc(lang('App.about_heading')) ?>
                </div>
            </div>
            <?php if (! empty($cvSkills)): ?>
                <div class="surface-card p-6 space-y-4">
                    <h4 class="u-text-primary text-lg font-semibold mb-3"><?= esc(lang('App.skills_section_title')) ?></h4>
                    <div class="grid gap-4 md:grid-cols-2">
                        <?php foreach ($cvSkills as $skill): ?>
                            <div>
                                <div class="flex justify-between text-xs u-text-muted mb-2">
                                    <span><?= esc($skill['label']) ?></span>
                                    <span><?= esc($skill['level']) ?>%</span>
                                </div>
                                <div class="w-full rounded-full bg-[var(--color-border-subtle)] h-2">
                                    <div class="h-full rounded-full bg-[var(--color-primary)]" style="width: <?= esc($skill['level']) ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="flex flex-wrap gap-3">
                <a class="btn-ghost" href="<?= site_url('/') ?>"><?= esc(lang('App.back_home')) ?></a>
                <a class="btn-ghost" href="<?= site_url('aktivitas') ?>"><?= esc(lang('App.activities_title')) ?></a>
                <a class="btn-ghost" href="<?= site_url('pendidikan') ?>"><?= esc(lang('App.education_section_title')) ?></a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
