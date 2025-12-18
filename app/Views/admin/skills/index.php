<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Keterampilan</p>
                <h1 class="section-title text-2xl mb-1">Kurasi kemampuan utama</h1>
                <p class="section-subtext mb-0">Pastikan kategori dan level skill tersusun rapi untuk portofolio publik.</p>
            </div>
            <a class="btn btn-primary rounded-pill d-flex align-items-center gap-2" href="<?= site_url('admin/skills/create') ?>">
                <i class="bi bi-plus-lg"></i> Tambah skill
            </a>
        </div>
    </section>
    <section class="card-shell p-0">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Level</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills as $skill): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-slate-900"><?= esc($skill['name']) ?></div>
                                <div class="text-token-secondary small"><?= esc($skill['description']) ?></div>
                            </td>
                            <td>
                                <span class="chip chip-muted text-uppercase"><?= esc($skill['category']) ?></span>
                            </td>
                            <td>
                                <span class="badge-soft success"><?= esc($skill['level']) ?>%</span>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?= site_url('admin/skills/' . $skill['id'] . '/edit') ?>">Edit</a>
                                <form action="<?= site_url('admin/skills/' . $skill['id'] . '/delete') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus skill?')">Hapus</button>
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
