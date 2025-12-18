<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $isEdit = ! empty($activity);
    $categoryOptions = [
        'kerja'   => 'Kerja',
        'kuliah'  => 'Kuliah',
        'rapat'   => 'Rapat',
        'pelatihan' => 'Pelatihan',
        'lainnya' => 'Lainnya',
    ];
?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label"><?= $isEdit ? 'Perbarui aktivitas' : 'Tambah aktivitas' ?></p>
                <h1 class="section-title text-2xl mb-1"><?= $isEdit ? 'Edit Aktivitas' : 'Tambah Aktivitas' ?></h1>
                <p class="section-subtext mb-0">Catat kegiatan tim secara konsisten agar panel aktivitas tetap informatif.</p>
            </div>
            <a class="btn btn-outline-secondary rounded-pill d-flex align-items-center gap-2" href="<?= site_url('admin/activities') ?>">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
    <section class="card-shell p-5">
        <form class="admin-form-grid two-col" action="<?= site_url($isEdit ? 'admin/activities/' . $activity['id'] : 'admin/activities') ?>" method="post">
            <?= csrf_field() ?>
            <div>
                <label class="form-label small text-token-muted">Judul aktivitas</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="title" value="<?= old('title', $activity['title'] ?? '') ?>" required>
            </div>
            <div>
                <label class="form-label small text-token-muted">Tanggal</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" type="date" name="activity_date" value="<?= old('activity_date', $activity['activity_date'] ?? date('Y-m-d')) ?>" required>
            </div>
            <div>
                <label class="form-label small text-token-muted">Kategori</label>
                <select class="form-select text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="category" required>
                    <?php foreach ($categoryOptions as $key => $label): ?>
                        <option value="<?= esc($key) ?>" <?= old('category', $activity['category'] ?? 'kerja') === $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label small text-token-muted">Lokasi</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="location" value="<?= old('location', $activity['location'] ?? '') ?>">
            </div>
            <div style="grid-column: span 2;">
                <label class="form-label small text-token-muted">Ikon (Bootstrap Icons)</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="icon" value="<?= old('icon', $activity['icon'] ?? 'bi-calendar-event') ?>">
                <small class="text-token-muted d-block mt-1">Contoh: <code>bi-briefcase</code>. Lihat daftar ikon di getbootstrap.com/icons.</small>
            </div>
            <div style="grid-column: span 2;">
                <label class="form-label small text-token-muted">Deskripsi</label>
                <textarea class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-4" rows="4" name="description"><?= old('description', $activity['description'] ?? '') ?></textarea>
            </div>
            <div class="d-flex justify-content-end gap-2" style="grid-column: span 2;">
                <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/activities') ?>">Batal</a>
                <button class="btn btn-primary rounded-pill" type="submit"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan' ?></button>
            </div>
        </form>
    </section>
</div>
<?= $this->endSection() ?>
