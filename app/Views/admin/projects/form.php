<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $isEdit = ! empty($project);
    $errors = session('errors') ?? [];
?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label"><?= $isEdit ? 'Perbarui proyek' : 'Tambah proyek' ?></p>
                <h1 class="section-title text-2xl mb-1"><?= $isEdit ? 'Edit Project' : 'Tambah Project' ?></h1>
                <p class="section-subtext mb-0">Lengkapi detail ringkas, deskripsi, dan status featured untuk portofolio.</p>
            </div>
            <a class="btn btn-outline-secondary rounded-pill d-flex align-items-center gap-2" href="<?= site_url('admin/projects') ?>">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
    <section class="card-shell p-5">
        <form class="admin-form-grid two-col" action="<?= site_url($isEdit ? 'admin/projects/' . $project['id'] : 'admin/projects') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div>
                <label class="form-label small text-token-muted">Judul</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['title']) ? 'is-invalid' : '' ?>" name="title" value="<?= old('title', $project['title'] ?? '') ?>" required>
                <?php if (isset($errors['title'])): ?><div class="invalid-feedback"><?= esc($errors['title']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Klien</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['client']) ? 'is-invalid' : '' ?>" name="client" value="<?= old('client', $project['client'] ?? '') ?>">
                <?php if (isset($errors['client'])): ?><div class="invalid-feedback"><?= esc($errors['client']) ?></div><?php endif; ?>
            </div>
            <div style="grid-column: span 2;">
                <label class="form-label small text-token-muted">Ringkasan</label>
                <textarea class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-4 <?= isset($errors['summary']) ? 'is-invalid' : '' ?>" name="summary" rows="2"><?= old('summary', $project['summary'] ?? '') ?></textarea>
                <?php if (isset($errors['summary'])): ?><div class="invalid-feedback"><?= esc($errors['summary']) ?></div><?php endif; ?>
            </div>
            <div style="grid-column: span 2;">
                <label class="form-label small text-token-muted">Deskripsi</label>
                <textarea class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-4 <?= isset($errors['description']) ? 'is-invalid' : '' ?>" name="description" rows="5"><?= old('description', $project['description'] ?? '') ?></textarea>
                <?php if (isset($errors['description'])): ?><div class="invalid-feedback"><?= esc($errors['description']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Teknologi</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['technologies']) ? 'is-invalid' : '' ?>" name="technologies" value="<?= old('technologies', $project['technologies'] ?? '') ?>">
                <?php if (isset($errors['technologies'])): ?><div class="invalid-feedback"><?= esc($errors['technologies']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Tanggal selesai</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['completed_at']) ? 'is-invalid' : '' ?>" type="date" name="completed_at" value="<?= old('completed_at', $project['completed_at'] ?? '') ?>">
                <?php if (isset($errors['completed_at'])): ?><div class="invalid-feedback"><?= esc($errors['completed_at']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">URL proyek</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['project_url']) ? 'is-invalid' : '' ?>" name="project_url" value="<?= old('project_url', $project['project_url'] ?? '') ?>">
                <?php if (isset($errors['project_url'])): ?><div class="invalid-feedback"><?= esc($errors['project_url']) ?></div><?php endif; ?>
            </div>
            <div>
                <label class="form-label small text-token-muted">Gambar proyek</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill <?= isset($errors['image']) ? 'is-invalid' : '' ?>" type="file" name="image">
                <small class="text-token-muted d-block mt-1">Format JPG/PNG, maksimal 2MB.</small>
                <?php if (isset($errors['image'])): ?><div class="invalid-feedback"><?= esc($errors['image']) ?></div><?php endif; ?>
                <?php if ($isEdit && ! empty($project['image'])): ?>
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <img src="<?= base_url($project['image']) ?>" width="120" class="rounded-3" alt="Preview project">
                        <span class="text-token-muted small">Gambar saat ini</span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="d-flex flex-column justify-content-end gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="isFeatured" name="is_featured" value="1" <?= old('is_featured', $project['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label text-token-secondary" for="isFeatured">Tampilkan sebagai featured</label>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2" style="grid-column: span 2;">
                <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/projects') ?>">Batal</a>
                <button class="btn btn-primary rounded-pill" type="submit"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Project' ?></button>
            </div>
        </form>
    </section>
</div>
<?= $this->endSection() ?>
