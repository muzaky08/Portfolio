<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $isEdit = ! empty($experience);
    $errors = session('errors') ?? [];
?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label"><?= $isEdit ? 'Perbarui pengalaman' : 'Tambah pengalaman' ?></p>
                <h1 class="section-title text-2xl mb-1"><?= $isEdit ? 'Edit Pengalaman' : 'Tambah Pengalaman' ?></h1>
                <p class="section-subtext mb-0">Lengkapi detail peran, perusahaan, dan periode kerja untuk portofolio publik.</p>
            </div>
            <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/experiences') ?>">
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
        <form class="admin-form-grid two-col" action="<?= site_url($isEdit ? 'admin/experiences/' . $experience['id'] : 'admin/experiences') ?>" method="post">
            <?= csrf_field() ?>
            <div>
                <label class="form-label small text-token-muted">Peran</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['role']) ? 'is-invalid' : '' ?>" name="role" value="<?= old('role', $experience['role'] ?? '') ?>" required>
                <?php if (isset($errors['role'])): ?><div class="invalid-feedback"><?= esc($errors['role']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Perusahaan</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['company']) ? 'is-invalid' : '' ?>" name="company" value="<?= old('company', $experience['company'] ?? '') ?>" required>
                <?php if (isset($errors['company'])): ?><div class="invalid-feedback"><?= esc($errors['company']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Lokasi</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['location']) ? 'is-invalid' : '' ?>" name="location" value="<?= old('location', $experience['location'] ?? '') ?>">
                <?php if (isset($errors['location'])): ?><div class="invalid-feedback"><?= esc($errors['location']) ?></div><?php endif; ?>
            </div>
            <div class="d-flex flex-column gap-3">
                <div>
                    <label class="form-label small text-token-muted">Mulai</label>
                    <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['start_date']) ? 'is-invalid' : '' ?>" type="date" name="start_date" value="<?= old('start_date', $experience['start_date'] ?? '') ?>" required>
                    <?php if (isset($errors['start_date'])): ?><div class="invalid-feedback"><?= esc($errors['start_date']) ?></div><?php endif; ?>
                </div>
                <div>
                    <label class="form-label small text-token-muted">Selesai</label>
                    <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['end_date']) ? 'is-invalid' : '' ?>" type="date" name="end_date" value="<?= old('end_date', $experience['end_date'] ?? '') ?>">
                    <?php if (isset($errors['end_date'])): ?><div class="invalid-feedback"><?= esc($errors['end_date']) ?></div><?php endif; ?>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-end" style="grid-column: span 2;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="isCurrent" name="is_current" value="1" <?= old('is_current', $experience['is_current'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label text-token-secondary" for="isCurrent">Masih aktif</label>
                </div>
            </div>
            <div style="grid-column: span 2;">
                <label class="form-label small text-token-muted">Deskripsi</label>
                <textarea class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-4 <?= isset($errors['description']) ? 'is-invalid' : '' ?>" name="description" rows="4"><?= old('description', $experience['description'] ?? '') ?></textarea>
                <?php if (isset($errors['description'])): ?><div class="invalid-feedback"><?= esc($errors['description']) ?></div><?php endif; ?>
            </div>
            <div class="d-flex justify-content-end gap-2" style="grid-column: span 2;">
                <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/experiences') ?>">Batal</a>
                <button class="btn btn-primary rounded-pill" type="submit"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Pengalaman' ?></button>
            </div>
        </form>
    </section>
</div>
<?= $this->endSection() ?>
