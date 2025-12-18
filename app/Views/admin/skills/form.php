<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $isEdit = ! empty($skill);
    $errors = session('errors') ?? [];
?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label"><?= $isEdit ? 'Perbarui keterampilan' : 'Tambah keterampilan' ?></p>
                <h1 class="section-title text-2xl mb-1"><?= $isEdit ? 'Edit Skill' : 'Tambah Skill' ?></h1>
                <p class="section-subtext mb-0">Pastikan nama, kategori, dan level proficiency konsisten dengan portofolio.</p>
            </div>
            <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/skills') ?>">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
    <section class="card-shell p-5">
        <form class="admin-form-grid two-col" action="<?= site_url($isEdit ? 'admin/skills/' . $skill['id'] : 'admin/skills') ?>" method="post">
            <?= csrf_field() ?>
            <div>
                <label class="form-label small text-token-muted">Nama skill</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['name']) ? 'is-invalid' : '' ?>" name="name" value="<?= old('name', $skill['name'] ?? '') ?>" required>
                <?php if (isset($errors['name'])): ?><div class="invalid-feedback"><?= esc($errors['name']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Kategori</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['category']) ? 'is-invalid' : '' ?>" name="category" value="<?= old('category', $skill['category'] ?? '') ?>">
                <?php if (isset($errors['category'])): ?><div class="invalid-feedback"><?= esc($errors['category']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Tingkat (%)</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['level']) ? 'is-invalid' : '' ?>" type="number" name="level" min="0" max="100" value="<?= old('level', $skill['level'] ?? 0) ?>" required>
                <?php if (isset($errors['level'])): ?><div class="invalid-feedback"><?= esc($errors['level']) ?></div><?php endif; ?>
            </div>
            <div style="grid-column: span 2;">
                <label class="form-label small text-token-muted">Deskripsi</label>
                <textarea class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-4 <?= isset($errors['description']) ? 'is-invalid' : '' ?>" name="description" rows="4" placeholder="Highlight kontribusi atau teknologi"><?= old('description', $skill['description'] ?? '') ?></textarea>
                <?php if (isset($errors['description'])): ?><div class="invalid-feedback"><?= esc($errors['description']) ?></div><?php endif; ?>
            </div>
            <div class="d-flex justify-content-end gap-2" style="grid-column: span 2;">
                <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/skills') ?>">Batal</a>
                <button class="btn btn-primary rounded-pill" type="submit"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Skill' ?></button>
            </div>
        </form>
    </section>
</div>
<?= $this->endSection() ?>
