<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Pengalaman</p>
                <h1 class="section-title text-2xl mb-1">Riwayat profesional</h1>
                <p class="section-subtext mb-0">Dokumentasikan peran penting beserta durasi agar profil publik selalu kontekstual.</p>
            </div>
            <a class="btn btn-primary rounded-pill d-flex align-items-center gap-2" href="<?= site_url('admin/experiences/create') ?>">
                <i class="bi bi-plus-lg"></i> Tambah pengalaman
            </a>
        </div>
    </section>
    <section class="card-shell p-0">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Perusahaan</th>
                        <th>Periode</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($experiences as $experience): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-slate-900"><?= esc($experience['role']) ?></div>
                                <div class="text-token-secondary small"><?= esc($experience['description']) ?></div>
                            </td>
                            <td class="text-token-secondary"><?= esc($experience['company']) ?></td>
                            <td class="text-token-secondary">
                                <?= esc($experience['start_date']) ?> -
                                <?= esc($experience['is_current'] ? 'Sekarang' : $experience['end_date']) ?>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?= site_url('admin/experiences/' . $experience['id'] . '/edit') ?>">Edit</a>
                                <form action="<?= site_url('admin/experiences/' . $experience['id'] . '/delete') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus pengalaman?')">Hapus</button>
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
