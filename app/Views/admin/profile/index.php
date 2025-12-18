<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php $profile = $profile ?? null; ?>
<style>
    .profile-form .form-control,
    .profile-form .form-select {
        border-radius: var(--radius-pill);
        border: 1px solid var(--color-border-subtle);
        background: color-mix(in srgb, var(--color-surface) 95%, transparent);
        color: var(--color-text-primary);
    }
    .profile-form ::placeholder { color: var(--color-text-muted); }
    .profile-form label {
        color: var(--color-text-secondary);
        font-weight: 600;
    }
    .profile-form .card-shell + .card-shell {
        margin-top: 1.5rem;
    }
    .profile-preview {
        background: color-mix(in srgb, var(--color-surface) 96%, transparent);
        border: 1px solid var(--color-border-subtle);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
    }
    .preview-card img {
        border: 4px solid color-mix(in srgb, var(--color-primary) 25%, transparent);
    }
    .token-muted { color: var(--color-text-muted); }
    .custom-file-input {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-pill);
    }
    .custom-file-input input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .editor-shell {
        border: 1px solid var(--color-border-subtle);
        border-radius: var(--radius-lg);
        background: color-mix(in srgb, var(--color-surface) 97%, transparent);
        padding: .35rem;
    }
    .editor-shell .tox-tinymce {
        border: none !important;
        box-shadow: none !important;
        background: transparent;
    }
    .profile-preview .contact-info {
        text-align: center;
    }
    .profile-preview .contact-info p {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
</style>
<div class="admin-page">
    <section class="card-shell p-6 d-flex flex-wrap align-items-start justify-content-between gap-3">
        <div>
            <p class="section-label">Biodata</p>
            <h1 class="section-title text-2xl mb-1">Biodata / CV</h1>
            <p class="section-subtext mb-0">Kelola informasi profil, foto, skill dan tautan sosial dengan preview langsung.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-outline-success rounded-pill" href="<?= site_url('admin/profile/backup') ?>">Backup JSON</a>
            <button class="btn btn-outline-secondary rounded-pill" type="button" data-restore-toggle>Restore JSON</button>
            <!-- Modal triggered from button -->
            <div class="modal fade" id="restoreModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-1">Restore Biodata</h5>
                                <p class="text-token-muted mb-0 small">Unggah file backup JSON untuk menimpa biodata saat ini.</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="restoreForm" action="<?= site_url('admin/profile/restore') ?>" method="post" enctype="multipart/form-data" novalidate>
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label small text-token-muted">File backup (JSON)</label>
                                <input class="form-control" type="file" name="backup_file" accept="application/json" required>
                                <div class="form-text text-token-muted">Pastikan file berasal dari fitur backup sistem ini.</div>
                            </div>
                            <div class="alert alert-warning small">
                                Mengunggah file ini akan mengganti seluruh biodata dan tautan sosial yang ada saat ini.
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-outline-secondary rounded-pill" type="button" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary rounded-pill" type="submit">Restore Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form action="<?= site_url('admin/profile') ?>" method="post" enctype="multipart/form-data" id="profileForm" class="profile-form">
    <?= csrf_field() ?>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-shell p-4 mb-4">
                <h5 class="section-title text-lg mb-3">Informasi Dasar</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input class="form-control preview-listener" data-preview="preview-name" name="full_name" value="<?= old('full_name', $profile['full_name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Posisi/Jabatan</label>
                        <input class="form-control preview-listener" data-preview="preview-title" name="job_title" value="<?= old('job_title', $profile['job_title'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control preview-listener" data-preview="preview-email" name="email" type="email" value="<?= old('email', $profile['email'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telepon</label>
                        <input class="form-control preview-listener" data-preview="preview-phone" name="phone" value="<?= old('phone', $profile['phone'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <input class="form-control preview-listener" data-preview="preview-address" name="address" value="<?= old('address', $profile['address'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi singkat</label>
                        <div class="editor-shell">
                            <textarea id="short_bio" class="form-control border-0 bg-transparent" name="short_bio" rows="5"><?= old('short_bio', $profile['short_bio'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-shell p-4 mb-4">
                <h5 class="section-title text-lg mb-3">Keahlian</h5>
                <div id="skillFields">
                    <?php $skills = old('skill_label') ? array_map(null, (array) old('skill_label'), (array) old('skill_level')) : ($profile['skills'] ?? []); ?>
                    <?php if (empty($skills)): $skills = [['label' => '', 'level' => 80]]; endif; ?>
                    <?php foreach ($skills as $index => $skill):
                        $label = is_array($skill) && isset($skill['label']) ? $skill['label'] : ($skill[0] ?? '');
                        $level = is_array($skill) && isset($skill['level']) ? $skill['level'] : ($skill[1] ?? 80);
                    ?>
                        <div class="row g-2 align-items-center mb-2 skill-row">
                            <div class="col-md-6"><input class="form-control" name="skill_label[]" placeholder="Nama skill" value="<?= esc($label) ?>"></div>
                            <div class="col-md-4"><input class="form-control" type="number" name="skill_level[]" placeholder="Level" min="1" max="100" value="<?= esc($level) ?>"></div>
                            <div class="col-md-2 text-end"><button class="btn btn-outline-danger btn-sm" type="button" onclick="removeRow(this)">Hapus</button></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="btn btn-outline-primary btn-sm rounded-pill" type="button" onclick="addSkillRow()">Tambah Skill</button>
            </div>
            <div class="card-shell p-4 mb-4">
                <h5 class="section-title text-lg mb-3">Media Sosial</h5>
                <div id="socialFields">
                    <?php $socials = old('social_label') ? array_map(null, (array) old('social_label'), (array) old('social_url'), (array) old('social_icon')) : ($profile['social_links'] ?? []); ?>
                    <?php if (empty($socials)): $socials = [['label' => 'LinkedIn', 'url' => '', 'icon' => 'bi-linkedin']]; endif; ?>
                    <?php foreach ($socials as $social):
                        $label = is_array($social) && isset($social['label']) ? $social['label'] : ($social[0] ?? '');
                        $url   = is_array($social) && isset($social['url']) ? $social['url'] : ($social[1] ?? '');
                        $icon  = is_array($social) && isset($social['icon']) ? $social['icon'] : ($social[2] ?? 'bi-link-45deg');
                    ?>
                        <div class="row g-2 align-items-center mb-2 social-row">
                            <div class="col-md-4"><input class="form-control" name="social_label[]" placeholder="Label" value="<?= esc($label) ?>"></div>
                            <div class="col-md-6"><input class="form-control" name="social_url[]" placeholder="URL" value="<?= esc($url) ?>"></div>
                            <div class="col-md-2"><input class="form-control" name="social_icon[]" placeholder="Ikon" value="<?= esc($icon) ?>"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="btn btn-outline-primary btn-sm rounded-pill" type="button" onclick="addSocialRow()">Tambah Link</button>
            </div>
            <div class="card-shell p-4 mb-4">
                <h5 class="section-title text-lg mb-3">Upload</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Foto Profil</label>
                        <input class="form-control" type="file" name="photo" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CV (PDF)</label>
                        <input class="form-control" type="file" name="cv_file" accept="application/pdf">
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-primary rounded-pill px-5" type="submit">Simpan Biodata</button>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="profile-preview p-4 preview-card d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <img class="rounded-circle mb-3 mx-auto d-block" src="<?= ! empty($profile['photo']) ? base_url($profile['photo']) : 'https://via.placeholder.com/150' ?>" id="preview-photo" width="150" height="150" style="object-fit:cover;">
                    <h4 id="preview-name"><?= esc($profile['full_name'] ?? 'Nama Lengkap') ?></h4>
                    <p class="text-token-muted" id="preview-title"><?= esc($profile['job_title'] ?? 'Jabatan') ?></p>
                    <div class="contact-info small text-token-muted">
                        <p class="mb-1" id="preview-email"><i class="bi bi-envelope me-2"></i><?= esc($profile['email'] ?? '-') ?></p>
                        <p class="mb-1" id="preview-phone"><i class="bi bi-telephone me-2"></i><?= esc($profile['phone'] ?? '-') ?></p>
                        <p class="mb-1" id="preview-address"><i class="bi bi-geo-alt me-2"></i><?= esc($profile['address'] ?? '-') ?></p>
                    </div>
                    <div id="preview-bio" class="mt-3 text-token-secondary small text-center"><?= ! empty($profile['short_bio']) ? $profile['short_bio'] : 'Deskripsi Anda akan tampil di sini.' ?></div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/tinymce@7.2.1/tinymce.min.js"></script>
<script>
    (function () {
        const restoreBtn = document.querySelector('[data-restore-toggle]');
        const restoreModalEl = document.getElementById('restoreModal');
        if (restoreBtn && restoreModalEl) {
            restoreBtn.addEventListener('click', () => {
                const modal = new bootstrap.Modal(restoreModalEl);
                modal.show();
            });
        }
    })();

    tinymce.init({
        selector: '#short_bio',
        menubar: false,
        height: 220,
        setup: function(editor) {
            editor.on('keyup change', function() {
                document.getElementById('preview-bio').innerHTML = editor.getContent();
            });
        }
    });

    document.querySelectorAll('.preview-listener').forEach(function(input) {
        input.addEventListener('input', function() {
            const target = document.getElementById(this.dataset.preview);
            if (target) target.textContent = this.value || target.dataset.default || '-';
        });
    });

    function addSkillRow() {
        const container = document.getElementById('skillFields');
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-center mb-2 skill-row';
        row.innerHTML = `
            <div class="col-md-6"><input class="form-control" name="skill_label[]" placeholder="Nama skill"></div>
            <div class="col-md-4"><input class="form-control" type="number" name="skill_level[]" placeholder="Level" min="1" max="100" value="80"></div>
            <div class="col-md-2 text-end"><button class="btn btn-outline-danger btn-sm" type="button" onclick="removeRow(this)">Hapus</button></div>
        `;
        container.appendChild(row);
    }

    function addSocialRow() {
        const container = document.getElementById('socialFields');
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-center mb-2 social-row';
        row.innerHTML = `
            <div class="col-md-4"><input class="form-control" name="social_label[]" placeholder="Label"></div>
            <div class="col-md-6"><input class="form-control" name="social_url[]" placeholder="URL"></div>
            <div class="col-md-2"><input class="form-control" name="social_icon[]" placeholder="Ikon" value="bi-link-45deg"></div>
        `;
        container.appendChild(row);
    }

    function removeRow(button) {
        const row = button.closest('.skill-row, .social-row');
        if (row) row.remove();
    }
</script>
<?= $this->endSection() ?>
