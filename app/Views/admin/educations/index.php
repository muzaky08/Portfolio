<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Pendidikan</p>
                <h1 class="section-title text-2xl mb-1">Riwayat pendidikan</h1>
                <p class="section-subtext mb-0">Kelola timeline pendidikan lengkap beserta filter jenjang dan urutan tahun.</p>
            </div>
            <a class="btn btn-primary rounded-pill d-flex align-items-center gap-2" href="<?= site_url('admin/educations/create') ?>">
                <i class="bi bi-plus-lg"></i> Tambah pendidikan
            </a>
        </div>
    </section>
    <section class="card-shell p-5">
        <form class="admin-form-grid two-col" method="get">
            <div>
                <label class="form-label small text-token-muted">Pencarian institusi</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>" placeholder="Nama institusi">
            </div>
            <div>
                <label class="form-label small text-token-muted">Jenjang</label>
                <select class="form-select text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="level">
                    <option value="">Semua</option>
                    <?php foreach (['SD','SMP','SMA','Kuliah'] as $level): ?>
                        <option value="<?= esc($level) ?>" <?= ($filters['level'] ?? '') === $level ? 'selected' : '' ?>><?= esc($level) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label small text-token-muted">Urutan tahun</label>
                <select class="form-select text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="sort">
                    <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Terlama</option>
                </select>
            </div>
            <div class="d-flex align-items-end justify-content-end gap-2">
                <button class="btn btn-outline-secondary rounded-pill" type="reset" onclick="window.location='<?= site_url('admin/educations') ?>'">Reset</button>
                <button class="btn btn-primary rounded-pill" type="submit">Filter</button>
            </div>
        </form>
    </section>
    <section class="card-shell p-0">
        <div class="px-4 pt-4 pb-2 d-flex flex-wrap justify-content-between gap-3 align-items-center">
            <div class="text-token-muted small">Menampilkan <?= $rangeStart ?> - <?= $rangeEnd ?> dari <?= $total ?> data</div>
            <form class="d-flex align-items-center gap-2" method="get">
                <?php foreach ($queryParams as $key => $value): ?>
                    <?php if ($key === 'per_page') continue; ?>
                    <?php if (is_array($value)): ?>
                        <?php foreach ($value as $v): ?>
                            <input type="hidden" name="<?= esc($key) ?>[]" value="<?= esc($v) ?>">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <input type="hidden" name="<?= esc($key) ?>" value="<?= esc($value) ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
                <label class="form-label small text-token-muted m-0">Per halaman</label>
                <select class="form-select form-select-sm text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="per_page" onchange="this.form.submit()">
                    <?php foreach ($perPageOpts as $opt): ?>
                        <option value="<?= $opt ?>" <?= $perPage === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Institusi</th>
                        <th>Jenjang</th>
                        <th>Periode</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($educations)): ?>
                        <?php foreach ($educations as $education): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (! empty($education['logo'])): ?>
                                            <img src="<?= base_url($education['logo']) ?>" width="40" height="40" class="rounded" style="object-fit:cover;">
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-semibold text-slate-900"><?= esc($education['institution']) ?></div>
                                            <div class="text-token-muted small">Sort order: <?= esc($education['sort_order']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="chip chip-muted text-uppercase"><?= esc($education['level']) ?></span></td>
                                <td><?= esc($education['start_year']) ?> - <?= esc($education['end_year']) ?></td>
                                <td class="text-token-secondary small"><?= esc($education['description']) ?></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-secondary rounded-pill" href="<?= site_url('admin/educations/' . $education['id'] . '/edit') ?>">Edit</a>
                                    <a class="btn btn-sm btn-outline-danger rounded-pill" href="<?= site_url('admin/educations/' . $education['id'] . '/delete') ?>" onclick="return confirm('Hapus data ini?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-token-muted py-4">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 pt-3">
            <?= $pager->links('educations', 'query_pager', ['params' => $queryParams]) ?>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
