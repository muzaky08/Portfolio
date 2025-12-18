<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Proyek</p>
                <h1 class="section-title text-2xl mb-1">Daftar proyek aktif</h1>
                <p class="section-subtext mb-0">Ringkas semua proyek unggulan lengkap dengan status featured.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/projects') ?>">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </a>
                <a class="btn btn-primary rounded-pill d-flex align-items-center gap-2" href="<?= site_url('admin/projects/create') ?>">
                    <i class="bi bi-plus-lg"></i> Tambah project
                </a>
            </div>
        </div>
    </section>
    <section class="card-shell p-0">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Klien</th>
                        <th>Teknologi</th>
                        <th>Featured</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-token-primary"><?= esc($project['title']) ?></div>
                                <div class="text-token-secondary small"><?= esc($project['summary']) ?></div>
                            </td>
                            <td class="text-token-secondary"><?= esc($project['client'] ?: '-') ?></td>
                            <td class="text-token-muted small"><?= esc($project['technologies']) ?></td>
                            <td>
                                <?php if ($project['is_featured']): ?>
                                    <span class="badge-soft success text-uppercase">Ya</span>
                                <?php else: ?>
                                    <span class="badge-soft chip-muted text-uppercase">Tidak</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?= site_url('admin/projects/' . $project['id'] . '/edit') ?>">Edit</a>
                                <form action="<?= site_url('admin/projects/' . $project['id'] . '/delete') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus project ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
