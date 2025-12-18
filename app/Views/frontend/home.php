<?= $this->extend('layouts/frontend') ?>
<?= $this->section('content') ?>
<?php
    $heroTitle      = $settings['hero_headline'] ?? 'Halo, saya Zaky';
    $heroSub        = $settings['hero_subheadline'] ?? 'Pengembang web full-stack';
    $summary        = $settings['about_summary'] ?? lang('App.about_heading');
    $contactEmail   = $contact['email'] ?? '';
    $contactPhone   = $contact['phone'] ?? '';
    $contactAddress = $contact['address'] ?? '';
    $profileData    = $profile ?? [];
    $heroPhoto      = ! empty($profileData['photo']) ? base_url($profileData['photo']) : null;
    $heroName       = $profileData['full_name'] ?? strip_tags($heroTitle);
    $heroRole       = $profileData['job_title'] ?? strip_tags($heroSub);
    $highlightCards = [
        [
            'title' => lang('App.activities_heading'),
            'copy'  => lang('App.activities_hint'),
            'icon'  => 'clock-5',
            'cta'   => ['href' => site_url('aktivitas'), 'label' => lang('App.activities_title')]
        ],
        [
            'title' => lang('App.cv_section_title'),
            'copy'  => 'Profil profesional lengkap dengan pengalaman unggulan dan kontak terpercaya.',
            'icon'  => 'user-round',
            'cta'   => ['href' => site_url('biodata'), 'label' => lang('App.cv_section_title')]
        ],
        [
            'title' => lang('App.education_section_title'),
            'copy'  => 'Jejak akademik dari sekolah dasar hingga pendidikan tinggi.',
            'icon'  => 'book-marked',
            'cta'   => ['href' => site_url('pendidikan'), 'label' => lang('App.education_section_title')]
        ],
    ];
?>
<section class="theme-shell section-gap" data-animate>
    <div class="surface-elevated p-8 pb-16 lg:px-12 lg:pt-12 lg:pb-20">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] items-center">
            <div class="space-y-6">
                <span class="eyebrow text-xl tracking-[0.45em] block">MY PORTOFOLIO</span>
                <div>
                    <h1 class="u-text-primary text-[48px] font-semibold leading-tight sm:text-[56px]">
                        <?= esc($heroTitle) ?>
                    </h1>
                    <p class="u-text-secondary text-2xl font-medium mt-2"><?= esc($heroSub) ?></p>
                </div>
                <p class="u-text-secondary text-lg leading-relaxed"><?= esc($summary) ?></p>
                <div class="flex flex-wrap gap-3 hero-cta">
                    <a class="btn-primary-brand inline-flex items-center gap-2" href="<?= site_url('biodata') ?>">
                        <i data-lucide="sparkles" class="h-5 w-5"></i>
                        <?= esc(lang('App.cv_section_title')) ?>
                    </a>
                    <a class="btn-ghost inline-flex items-center gap-2" href="<?= site_url('aktivitas') ?>">
                        <?= esc(lang('App.activities_title')) ?>
                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
            <div class="relative flex justify-center">
                <div class="absolute inset-y-10 left-1/2 w-3/4 -translate-x-1/2 rounded-full bg-[var(--color-primary)]/18 blur-3xl"></div>
                <div class="relative flex w-full max-w-sm flex-col items-center gap-0 text-center">
                    <?php if ($heroPhoto): ?>
                        <img class="h-[410px] w-auto max-w-full object-contain drop-shadow-[0_35px_60px_rgba(15,23,42,0.55)]" src="<?= esc($heroPhoto) ?>" alt="<?= esc($heroName) ?>">
                    <?php else: ?>
                        <div class="flex h-[420px] w-full items-center justify-center rounded-[2rem] border border-dashed border-[var(--color-border-subtle)] text-sm u-text-secondary">
                            Unggah foto transparan melalui panel admin untuk menampilkan visual personal.
                        </div>
                    <?php endif; ?>
                    <div class="inline-flex flex-col items-center gap-1 rounded-full border border-[var(--color-border-subtle)]/60 bg-[color-mix(in_srgb,_var(--color-bg)_90%,_transparent)] px-4 py-1.5 backdrop-blur">
                        <p class="u-text-primary text-base font-semibold leading-tight"><?= esc($heroName) ?></p>
                        <p class="u-text-secondary text-[0.65rem] uppercase tracking-[0.25em]"><?= esc($heroRole) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <div class="text-center space-y-3 mb-10">
        <p class="eyebrow">Kapabilitas</p>
        <h2 class="u-text-primary text-[36px] font-semibold">Spektrum karya dan peran</h2>
        <p class="u-text-secondary text-base">Fondasi personal branding ditopang oleh insight aktivitas, biodata, dan pendidikan.</p>
    </div>
    <div class="grid gap-6 lg:grid-cols-3">
        <?php foreach ($highlightCards as $card): ?>
            <article class="surface-card p-6 flex flex-col gap-4">
                <div class="badge-soft w-fit">
                    <i data-lucide="<?= esc($card['icon']) ?>" class="h-4 w-4 me-2"></i><?= esc($card['title']) ?>
                </div>
                <p class="u-text-secondary text-sm leading-relaxed flex-1"><?= esc($card['copy']) ?></p>
                <a class="u-text-primary text-sm font-semibold inline-flex items-center gap-2" href="<?= esc($card['cta']['href']) ?>">
                    <?= esc($card['cta']['label']) ?>
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <div class="grid gap-8 lg:grid-cols-5">
        <div class="surface-card p-6 lg:col-span-3 space-y-4">
            <div>
                <p class="eyebrow"><?= esc(lang('App.activities_title')) ?></p>
                <h2 class="u-text-primary text-[28px] font-semibold"><?= esc(lang('App.activities_heading')) ?></h2>
            </div>
            <?php if (! empty($activitySample)): ?>
                <div class="space-y-4">
                    <?php foreach ($activitySample as $activity): ?>
                        <article class="surface-elevated p-5">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <h3 class="u-text-primary text-lg font-semibold"><?= esc($activity['title']) ?></h3>
                                    <p class="u-text-secondary text-sm"><?= esc($activity['location']) ?> &middot; <?= esc(date('d M Y', strtotime($activity['activity_date']))) ?></p>
                                </div>
                                <span class="badge-soft"><?= esc($activity['category']) ?></span>
                            </div>
                            <p class="u-text-secondary text-sm leading-relaxed mt-3 line-clamp-2"><?= esc($activity['description']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
                <a class="btn-ghost inline-flex items-center gap-2 w-fit" href="<?= site_url('aktivitas') ?>">
                    Lihat semua aktivitas <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                </a>
            <?php else: ?>
                <div class="surface-elevated p-6 text-center u-text-secondary text-sm"><?= esc(lang('App.activity_empty')) ?></div>
            <?php endif; ?>
        </div>
        <aside class="surface-card p-6 space-y-4 lg:col-span-2">
            <div>
                <p class="eyebrow"><?= esc(lang('App.education_section_title')) ?></p>
                <h2 class="u-text-primary text-[28px] font-semibold"><?= esc(lang('App.education_section_heading')) ?></h2>
            </div>
            <?php if (! empty($educationSample)): ?>
                <div class="space-y-5">
                    <?php foreach ($educationSample as $education): ?>
                        <div class="surface-elevated p-4 space-y-1">
                            <p class="eyebrow"><?= esc($education['level']) ?></p>
                            <h3 class="u-text-primary text-lg font-semibold"><?= esc($education['institution']) ?></h3>
                            <p class="u-text-muted text-sm"><?= esc($education['major'] ?? '-') ?></p>
                            <span class="u-text-muted text-xs font-semibold"><?= esc($education['start_year']) ?> - <?= esc($education['end_year']) ?></span>
                            <p class="u-text-secondary text-sm leading-relaxed mt-2 line-clamp-3"><?= esc($education['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="u-text-primary text-sm font-semibold inline-flex items-center gap-2" href="<?= site_url('pendidikan') ?>">
                    Lihat riwayat lengkap <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            <?php else: ?>
                <div class="surface-elevated p-6 text-center u-text-secondary text-sm"><?= esc(lang('App.education_empty')) ?></div>
            <?php endif; ?>
        </aside>
    </div>
</section>
<section class="theme-shell section-gap" data-animate>
    <div class="grid gap-8 lg:grid-cols-5">
        <div class="surface-card p-6 space-y-4 lg:col-span-2">
            <p class="eyebrow">Kontak</p>
            <h2 class="u-text-primary text-[28px] font-semibold">Mari diskusikan idemu</h2>
            <ul class="space-y-3 u-text-secondary text-sm">
                <li class="flex items-center gap-3">
                    <i data-lucide="mail" class="h-4 w-4 text-[var(--color-primary)]"></i>
                    <a class="hover:underline" href="mailto:<?= esc($contactEmail) ?>"><?= esc($contactEmail) ?></a>
                </li>
                <li class="flex items-center gap-3">
                    <i data-lucide="phone" class="h-4 w-4 text-[var(--color-primary)]"></i>
                    <a class="hover:underline" href="tel:<?= esc(preg_replace('/[^0-9+]/', '', $contactPhone ?? '')) ?>"><?= esc($contactPhone) ?></a>
                </li>
                <li class="flex items-center gap-3">
                    <i data-lucide="map-pin" class="h-4 w-4 text-[var(--color-primary)]"></i>
                    <a class="hover:underline" target="_blank" href="https://www.google.com/maps/search/<?= urlencode($contactAddress ?? '') ?>"><?= esc($contactAddress) ?></a>
                </li>
            </ul>
        </div>
        <div class="surface-card p-6 lg:col-span-3">
            <?php if (session('success')): ?>
                <div class="mb-4 rounded-2xl border border-[var(--color-success)]/20 bg-[var(--color-success)]/10 px-4 py-3 text-sm text-[var(--color-success)]"><?= esc(session('success')) ?></div>
            <?php endif; ?>
            <?php if (session('errors')): ?>
                <div class="mb-4 rounded-2xl border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc ps-5">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?= site_url('contact') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="form-field">
                        <label><?= esc(lang('App.contact_form_name')) ?></label>
                        <input name="name" value="<?= old('name') ?>" required>
                    </div>
                    <div class="form-field">
                        <label><?= esc(lang('App.contact_form_email')) ?></label>
                        <input name="email" type="email" value="<?= old('email') ?>" required>
                    </div>
                </div>
                <div class="form-field">
                    <label><?= esc(lang('App.contact_form_subject')) ?></label>
                    <input name="subject" value="<?= old('subject') ?>">
                </div>
                <div class="form-field">
                    <label><?= esc(lang('App.contact_form_message')) ?></label>
                    <textarea name="message" rows="5" required><?= old('message') ?></textarea>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3 contact-actions">
                    <p class="u-text-muted text-xs">Respon dalam 24 jam kerja.</p>
                    <button class="btn-primary-brand inline-flex items-center gap-2" type="submit">
                        <i data-lucide="send" class="h-4 w-4"></i>
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
