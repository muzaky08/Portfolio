<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $isEdit  = ! empty($education);
    $errors  = session('errors') ?? [];
    $levels  = ['SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA', 'Kuliah' => 'Kuliah'];
?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label"><?= $isEdit ? 'Perbarui entri' : 'Tambah entri' ?></p>
                <h1 class="section-title text-2xl mb-1"><?= $isEdit ? 'Edit Pendidikan' : 'Tambah Pendidikan' ?></h1>
                <p class="section-subtext mb-0">Kelola detail institusi, periode, dan cerita pendidikan.</p>
            </div>
            <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/educations') ?>">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
    <?php if ($flashError = session('error')): ?>
        <section class="card-shell p-5 pt-4">
            <div class="alert alert-danger rounded-4 mb-0"><?= esc($flashError) ?></div>
        </section>
    <?php endif; ?>
    <section class="card-shell p-5">
        <form class="admin-form-grid two-col" action="<?= site_url($isEdit ? 'admin/educations/' . $education['id'] : 'admin/educations') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div>
                <label class="form-label small text-token-muted">Nama institusi</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['institution']) ? 'is-invalid' : '' ?>" name="institution" value="<?= old('institution', $education['institution'] ?? '') ?>" required>
                <?php if (isset($errors['institution'])): ?><div class="invalid-feedback"><?= esc($errors['institution']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Jenjang</label>
                <select class="form-select text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['level']) ? 'is-invalid' : '' ?>" name="level" required>
                    <option value="">Pilih jenjang</option>
                    <?php foreach ($levels as $value => $label): ?>
                        <option value="<?= esc($value) ?>" <?= old('level', $education['level'] ?? '') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['level'])): ?><div class="invalid-feedback"><?= esc($errors['level']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Jurusan / Program</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['major']) ? 'is-invalid' : '' ?>" name="major" value="<?= old('major', $education['major'] ?? '') ?>">
                <?php if (isset($errors['major'])): ?><div class="invalid-feedback"><?= esc($errors['major']) ?></div><?php endif; ?>
            </div>
            <div class="d-flex flex-column gap-3">
                <div>
                    <label class="form-label small text-token-muted">Tahun mulai</label>
                    <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['start_year']) ? 'is-invalid' : '' ?>" type="number" name="start_year" min="1900" max="<?= date('Y') ?>" value="<?= old('start_year', $education['start_year'] ?? '') ?>" required>
                    <?php if (isset($errors['start_year'])): ?><div class="invalid-feedback"><?= esc($errors['start_year']) ?></div><?php endif; ?>
                </div>
                <div>
                    <label class="form-label small text-token-muted">Tahun selesai</label>
                    <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['end_year']) ? 'is-invalid' : '' ?>" type="number" name="end_year" min="1900" max="<?= date('Y') + 10 ?>" value="<?= old('end_year', $education['end_year'] ?? '') ?>" required>
                    <?php if (isset($errors['end_year'])): ?><div class="invalid-feedback"><?= esc($errors['end_year']) ?></div><?php endif; ?>
                </div>
            </div>
            <div>
                <label class="form-label small text-token-muted">Urutan tampilan</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['sort_order']) ? 'is-invalid' : '' ?>" type="number" name="sort_order" value="<?= old('sort_order', $education['sort_order'] ?? '') ?>">
                <?php if (isset($errors['sort_order'])): ?><div class="invalid-feedback"><?= esc($errors['sort_order']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Logo institusi</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['logo']) ? 'is-invalid' : '' ?>" type="file" name="logo" accept="image/*">
                <small class="text-token-muted d-block mt-1">Maksimal 2MB. Format JPG, PNG, SVG.</small>
                <?php if (isset($errors['logo'])): ?><div class="invalid-feedback"><?= esc($errors['logo']) ?></div><?php endif; ?>
                <?php if ($isEdit && ! empty($education['logo'])): ?>
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <img src="<?= base_url($education['logo']) ?>" width="80" height="80" class="rounded" style="object-fit:cover;" alt="Logo saat ini">
                        <span class="text-token-muted small">Logo saat ini</span>
                    </div>
                <?php endif; ?>
            </div>
            <div style="grid-column: span 2;">
                <label class="form-label small text-token-muted">Deskripsi</label>
                <textarea class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-4 <?= isset($errors['description']) ? 'is-invalid' : '' ?>" name="description" rows="4" placeholder="Ceritakan perjalanan pendidikan"><?= old('description', $education['description'] ?? '') ?></textarea>
                <?php if (isset($errors['description'])): ?><div class="invalid-feedback"><?= esc($errors['description']) ?></div><?php endif; ?>
            </div>
            <div class="d-flex justify-content-end gap-2" style="grid-column: span 2;">
                <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/educations') ?>">Batal</a>
                <button class="btn btn-primary rounded-pill" type="submit"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Pendidikan' ?></button>
            </div>
        </form>
    </section>
</div>
<?= $this->endSection() ?>
