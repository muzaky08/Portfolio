<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Pengaturan</p>
                <h1 class="section-title text-2xl mb-1">Manajemen konten publik</h1>
                <p class="section-subtext mb-0">Perbarui copywriting hero, metadata SEO, hingga detail kontak agar sinkron dengan tampilan publik.</p>
            </div>
            <button class="btn btn-outline-secondary rounded-pill d-flex align-items-center gap-2" type="button" onclick="window.location.reload()">
                <i class="bi bi-arrow-repeat"></i> Muat ulang
            </button>
        </div>
    </section>
    <form action="<?= site_url('admin/settings') ?>" method="post" class="d-flex flex-column gap-4">
        <?= csrf_field() ?>
        <?php foreach ($groups as $section => $fields): ?>
            <section class="card-shell p-5">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                    <div>
                        <p class="section-label"><?= esc($section) ?></p>
                        <h2 class="section-title text-xl mb-0 text-capitalize"><?= esc(str_replace('_', ' ', $section)) ?></h2>
                    </div>
                    <span class="chip chip-muted"><?= count($fields) ?> field</span>
                </div>
                <div class="admin-form-grid">
                    <?php foreach ($fields as $key => $meta): ?>
                        <div>
                            <label class="form-label fw-semibold text-slate-900"><?= esc($meta['label']) ?></label>
                            <?php $type = $meta['type'] ?? 'input'; ?>
                            <?php if ($type === 'textarea'): ?>
                                <textarea class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="<?= esc($key) ?>" rows="3"><?= old($key, $settings[$key] ?? '') ?></textarea>
                            <?php else: ?>
                                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="<?= esc($key) ?>" value="<?= old($key, $settings[$key] ?? '') ?>">
                            <?php endif; ?>
                            <?php if (! empty($meta['hint'])): ?>
                                <small class="text-token-muted d-block mt-1"><?= esc($meta['hint']) ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
        <div class="text-end mt-1">
            <button class="btn btn-primary rounded-pill px-5" type="submit">Simpan pengaturan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
