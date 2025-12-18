<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Maintenance</p>
                <h1 class="section-title text-2xl mb-1">Backup System</h1>
                <p class="section-subtext mb-0">Generate arsip JSON seluruh konten CMS untuk restore atau migrasi server.</p>
            </div>
            <a class="btn btn-primary rounded-pill d-flex align-items-center gap-2" href="<?= site_url('admin/backups/generate') ?>">
                <i class="bi bi-arrow-repeat"></i>
                Generate &amp; Download
            </a>
        </div>
    </section>
    <section class="card-shell p-5">
        <div class="rounded-4 p-4" style="border: 1px solid var(--color-border-subtle); background: color-mix(in srgb, var(--color-surface) 95%, transparent);">
            <p class="mb-2 text-token-secondary">Gunakan perintah berikut untuk backup otomatis (cron):</p>
            <code class="d-inline-flex px-3 py-2 rounded-pill bg-brand-soft text-brand fw-semibold">php spark portfolio:backup</code>
        </div>
    </section>
    <section class="card-shell p-0">
        <div class="px-4 pt-4 pb-2 d-flex flex-wrap justify-content-between gap-3 align-items-center">
            <div class="text-token-muted small">Riwayat backup (<?= count($archives) ?> file)</div>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama File</th>
                        <th>Ukuran</th>
                        <th>Dibuat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($archives)): ?>
                        <?php foreach ($archives as $archive): ?>
                            <tr>
                                <td class="fw-semibold text-token-primary"><?= esc($archive['name']) ?></td>
                                <td class="text-token-secondary"><?= number_format($archive['size'] / 1024 / 1024, 2) ?> MB</td>
                                <td class="text-token-secondary"><?= esc(date('d M Y H:i', $archive['updated_at'])) ?></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?= site_url('admin/backups/download/' . urlencode($archive['name'])) ?>">Download</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-token-muted py-4">Belum ada file backup.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
