<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $categoriesOptions = [
        'kerja'   => 'Kerja',
        'kuliah'  => 'Kuliah',
        'rapat'   => 'Rapat',
        'pelatihan' => 'Pelatihan',
        'lainnya' => 'Lainnya',
    ];
    $currentCategory = $filters['categories'][0] ?? null;
    $activeFilters = [];
    if (! empty($filters['keyword'])) {
        $activeFilters[] = 'Keyword: ' . esc($filters['keyword']);
    }
    if ($currentCategory) {
        $activeFilters[] = 'Kategori: ' . esc($categoriesOptions[$currentCategory] ?? ucfirst($currentCategory));
    }
    if (! empty($filters['start_date']) || ! empty($filters['end_date'])) {
        $activeFilters[] = 'Tanggal: ' . esc($filters['start_date'] ?: '-') . ' s/d ' . esc($filters['end_date'] ?: '-');
    }
    $categoryColors = [
        'kerja' => 'badge-soft-blue',
        'kuliah' => 'badge-soft-emerald',
        'rapat' => 'badge-soft-purple',
        'pelatihan' => 'badge-soft-amber',
        'lainnya' => 'badge-soft-slate',
    ];
?>
<style>
    .activity-page { display: flex; flex-direction: column; gap: 2.5rem; }
    .activity-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1.5rem;
        padding: 2rem;
        background: var(--color-surface);
        border: 1px solid var(--color-border-subtle);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
    }
    .activity-title h1 {
        margin: 0;
        font-size: 1.9rem;
        letter-spacing: -.02em;
        color: var(--color-text-primary);
    }
    .activity-title p {
        margin: .35rem 0 0;
        color: var(--color-text-secondary);
    }
    .action-group {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .85rem;
    }
    .action-group .btn {
        border-radius: var(--radius-pill);
        padding: .65rem 1.4rem;
        font-weight: 600;
    }
    .export-group {
        display: flex;
        border: 1px solid var(--color-border-subtle);
        border-radius: var(--radius-pill);
        overflow: hidden;
        background: color-mix(in srgb, var(--color-surface) 95%, transparent);
    }
    .export-group a {
        padding: .55rem 1.1rem;
        text-decoration: none;
        color: var(--color-text-primary);
        display: flex;
        align-items: center;
        gap: .4rem;
        font-weight: 500;
        transition: var(--transition-base);
    }
    .export-group a + a {
        border-left: 1px solid var(--color-border-subtle);
    }
    .export-group a:hover {
        background: color-mix(in srgb, var(--color-primary) 12%, transparent);
        color: var(--color-primary);
    }
    .activity-filters {
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border-subtle);
        background: var(--color-surface);
        box-shadow: var(--shadow-card);
    }
    .filter-toggle {
        border: none;
        width: 100%;
        background: none;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--color-text-primary);
    }
    .filter-toggle span { display: block; color: var(--color-text-secondary); font-size: .85rem; font-weight: normal; }
    .filter-body {
        padding: 0 2rem 1.75rem;
        gap: 1.25rem;
    }
    .filter-body.collapsed { display: none; }
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.2rem 1.5rem;
    }
    .input-shell {
        border: 1px solid var(--color-border-subtle);
        border-radius: var(--radius-pill);
        background: color-mix(in srgb, var(--color-surface) 92%, transparent);
        padding: .35rem .85rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .input-shell .form-select,
    .input-shell .form-control {
        background: transparent;
        border: none;
        border-radius: 0;
        box-shadow: none;
        padding: 0;
        color: var(--color-text-primary);
    }
    .text-token-muted { color: var(--color-text-muted) !important; }
    .text-token-secondary { color: var(--color-text-secondary) !important; }
    .input-shell input,
    .input-shell select {
        border: none;
        background: transparent;
        width: 100%;
        outline: none;
        padding: .45rem 0;
        color: var(--color-text-primary);
    }
    .input-shell input::placeholder,
    .input-shell textarea::placeholder {
        color: var(--color-text-secondary);
        opacity: 0.85;
    }
    .form-select,
    .form-control {
        color: var(--color-text-primary);
        background-color: color-mix(in srgb, var(--color-surface) 94%, transparent);
        border-color: var(--color-border-subtle);
        border-radius: var(--radius-pill);
    }
    .form-select:focus,
    .form-control:focus {
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-primary) 25%, transparent);
        border-color: var(--color-primary);
        background-color: color-mix(in srgb, var(--color-surface) 98%, transparent);
        color: var(--color-text-primary);
    }
    .form-select option {
        background: var(--color-surface);
        color: var(--color-text-primary);
    }
    .input-shell i { color: var(--color-text-muted); font-size: 1.1rem; }
    .chip-stack {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        margin-top: .5rem;
    }
    .chip {
        background: color-mix(in srgb, var(--color-primary) 12%, transparent);
        color: var(--color-primary);
        border-radius: var(--radius-pill);
        padding: .25rem .75rem;
        font-size: .8rem;
        font-weight: 600;
    }
    .filter-footer {
        display: flex;
        justify-content: flex-end;
        gap: .75rem;
        margin-top: 1.5rem;
    }
    .filter-mobile-open {
        display: none;
    }
    .filter-backdrop {
        display: none;
    }
    body.mobile-filter-open .filter-backdrop {
        display: block;
        position: fixed;
        inset: 0;
        background: rgba(2, 6, 23, .55);
        z-index: 1040;
        backdrop-filter: blur(4px);
    }
    body.mobile-filter-open .activity-filters {
        position: fixed;
        inset: 0;
        margin: 0;
        border-radius: 0;
        z-index: 1050;
        overflow: auto;
        animation: slideUp .35s ease;
    }
    @keyframes slideUp {
        from { transform: translateY(15px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .data-panel {
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border-subtle);
        background: var(--color-surface);
        box-shadow: var(--shadow-card);
    }
    .table-hint {
        padding: 1.5rem 2rem 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
    }
    .table-hint .text-muted { color: var(--color-text-muted) !important; }
    .activity-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .activity-table thead th {
        position: sticky;
        top: 0;
        background: color-mix(in srgb, var(--color-surface-elevated) 80%, transparent);
        z-index: 1;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--color-text-muted);
        border-bottom: 1px solid var(--color-border-subtle);
    }
    .activity-table th,
    .activity-table td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }
    .activity-table tbody tr:nth-child(even) { background: color-mix(in srgb, var(--color-surface) 96%, transparent); }
    .activity-table tbody tr:hover { background: color-mix(in srgb, var(--color-primary) 8%, transparent); }
    .text-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .badge-soft-blue { background: color-mix(in srgb, var(--color-primary) 18%, transparent); color: var(--color-primary); }
    .badge-soft-emerald { background: color-mix(in srgb, var(--color-success) 20%, transparent); color: var(--color-success); }
    .badge-soft-purple { background: color-mix(in srgb, var(--color-accent) 18%, transparent); color: var(--color-accent); }
    .badge-soft-amber { background: color-mix(in srgb, var(--color-warning) 22%, transparent); color: var(--color-warning); }
    .badge-soft-slate { background: color-mix(in srgb, var(--color-text-muted) 25%, transparent); color: var(--color-text-primary); }
    .icon-btn {
        width: 38px;
        height: 38px;
        border: 1px solid var(--color-border-subtle);
        border-radius: 12px;
        background: var(--color-surface);
        color: var(--color-text-secondary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background .2s, color .2s, border-color .2s;
    }
    .icon-btn:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
    }
    .icon-btn.danger:hover {
        border-color: #dc2626;
        color: #dc2626;
    }
    .activity-cards { display: none; padding: 1rem 1.5rem 1.5rem; }
    .activity-card {
        border: 1px solid var(--color-border-subtle);
        border-radius: 1.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: var(--color-surface);
        box-shadow: 0 15px 35px rgba(15, 23, 42, .06);
    }
    .activity-card h5 { margin: 0 0 .5rem; color: var(--color-text-primary); }
    .activity-card .meta { display: flex; flex-wrap: wrap; gap: .75rem; font-size: .85rem; color: var(--color-text-muted); }
    .activity-card .card-actions { display: flex; justify-content: flex-end; gap: .5rem; margin-top: .75rem; }
    .skeleton-table {
        padding: 1rem 1.5rem;
        display: grid;
        gap: .75rem;
    }
    .skeleton-line {
        height: 14px;
        border-radius: 999px;
        background: linear-gradient(90deg, color-mix(in srgb, var(--color-surface) 80%, transparent), color-mix(in srgb, var(--color-border-subtle) 90%, transparent), color-mix(in srgb, var(--color-surface) 80%, transparent));
        background-size: 200% 100%;
        animation: shimmer 1.4s ease infinite;
    }
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    .empty-state {
        text-align: center;
        padding: 2.5rem 1.5rem 3rem;
        color: var(--color-text-muted);
    }
    .empty-state img {
        max-width: 220px;
        margin-bottom: 1rem;
    }
    .table-footer {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--color-border-subtle);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .table-footer form { display: flex; flex-wrap: wrap; align-items: center; gap: .5rem; }
    .toast-container { z-index: 2000; }
    .focus-ring:focus-visible {
        outline: 3px solid color-mix(in srgb, var(--color-primary) 35%, transparent);
        outline-offset: 2px;
    }
    @media (max-width: 992px) {
        .activity-header { padding: 1.5rem; }
    }
    @media (max-width: 768px) {
        .filter-mobile-open {
            display: inline-flex;
        }
        .filter-footer {
            position: sticky;
            bottom: 0;
            background: var(--color-surface);
            padding-top: 1rem;
            border-top: 1px solid var(--color-border-subtle);
        }
        .table-responsive {
            display: none;
        }
        .activity-cards { display: block; }
    }
</style>
<div class="activity-page admin-page" id="activityPage">
    <div class="activity-header">
        <div class="activity-title">
            <p class="section-label mb-1">Aktivitas harian</p>
            <h1 class="section-title text-3xl">Dashboard aktivitas</h1>
            <p class="section-subtext">Manajemen kegiatan staf, filter multi dimensi, dan ekspor dengan cepat.</p>
        </div>
        <div class="action-group">
            <button class="btn btn-outline-secondary focus-ring filter-mobile-open d-lg-none" type="button" data-filter-open>
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
            <div class="export-group focus-ring" role="group" aria-label="Ekspor data">
                <a href="<?= site_url('admin/activities/export/csv?' . http_build_query($queryParams)) ?>">
                    <i class="bi bi-filetype-csv"></i> CSV
                </a>
                <a href="<?= site_url('admin/activities/export/excel?' . http_build_query($queryParams)) ?>">
                    <i class="bi bi-filetype-xls"></i> Excel
                </a>
            </div>
            <a class="btn btn-primary focus-ring d-flex align-items-center gap-2" href="<?= site_url('admin/activities/create') ?>">
                <i class="bi bi-plus-lg"></i>
                Tambah Aktivitas
            </a>
        </div>
    </div>
    <div class="filter-backdrop" data-filter-close></div>
    <form id="activityFilterForm" class="activity-filters" method="get" data-filter-card>
        <button class="filter-toggle focus-ring" type="button" data-filter-toggle aria-expanded="true">
            <div>
                <span class="section-label d-block mb-1 text-start">Kelola filter pencarian</span>
                <small class="text-token-muted"><?= ! empty($activeFilters) ? count($activeFilters) . ' filter aktif' : 'Tidak ada filter aktif' ?></small>
            </div>
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="filter-body" id="filterBody">
            <div class="filter-grid">
                <label class="input-shell w-100">
                    <i class="bi bi-search"></i>
                    <input type="search" name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>" placeholder="Cari judul, deskripsi, lokasi">
                </label>
                <div>
                    <label class="small text-token-muted mb-1 d-flex justify-content-between align-items-center">
                        <span>Kategori</span>
                        <button class="btn btn-sm btn-link text-decoration-none p-0 text-token-muted" type="button" data-chip-reset>Reset</button>
                    </label>
                    <div class="d-flex flex-column gap-2">
                        <label class="input-shell">
                            <i class="bi bi-tags"></i>
                            <select class="form-select border-0 bg-transparent p-0" name="category[]" id="categorySelect">
                                <option value="">Semua kategori</option>
                                <?php foreach ($categoriesOptions as $key => $label): ?>
                                    <option value="<?= esc($key) ?>" <?= ($currentCategory ?? '') === $key ? 'selected' : '' ?>>
                                        <?= esc($label) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <div class="chip-stack mt-1" id="categoryChips">
                            <?php if ($currentCategory): ?>
                                <span class="chip"><?= esc($categoriesOptions[$currentCategory] ?? ucfirst($currentCategory)) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="small text-token-muted mb-1 d-block">Rentang tanggal</label>
                    <div class="d-flex flex-column gap-2">
                        <label class="input-shell">
                            <i class="bi bi-calendar2-event"></i>
                            <input type="date" class="form-control border-0 bg-transparent p-0" name="start_date" value="<?= esc($filters['start_date'] ?? '') ?>">
                        </label>
                        <label class="input-shell">
                            <i class="bi bi-calendar-check"></i>
                            <input type="date" class="form-control border-0 bg-transparent p-0" name="end_date" value="<?= esc($filters['end_date'] ?? '') ?>">
                        </label>
                    </div>
                </div>
                <label class="input-shell">
                    <i class="bi bi-arrow-down-up"></i>
                    <select name="sort_dir">
                        <option value="desc" <?= $sortDir === 'desc' ? 'selected' : '' ?>>Urutkan terbaru</option>
                        <option value="asc" <?= $sortDir === 'asc' ? 'selected' : '' ?>>Urutkan terlama</option>
                    </select>
                </label>
            </div>
            <input type="hidden" name="sort_by" value="<?= esc($sortBy) ?>">
            <input type="hidden" name="per_page" value="<?= esc($perPage) ?>">
            <div class="filter-footer">
                <button class="btn btn-outline-secondary focus-ring" type="button" data-filter-close>Batalkan</button>
                <button class="btn btn-outline-secondary focus-ring" type="reset" onclick="window.location='<?= site_url('admin/activities') ?>'">Reset</button>
                <button class="btn btn-primary focus-ring d-flex align-items-center gap-2" type="submit">
                    <i class="bi bi-funnel"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </form>
    <?php if (! empty($activeFilters)): ?>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="text-token-muted small">Filter aktif:</span>
            <?php foreach ($activeFilters as $label): ?>
                <span class="chip chip-muted"><?= $label ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="data-panel">
        <div class="table-hint">
            <div class="text-token-muted small">Menampilkan <?= $rangeStart ?> - <?= $rangeEnd ?> dari <?= $total ?> aktivitas</div>
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
                <label class="small text-token-muted mb-0">Baris per halaman</label>
                <select class="form-select form-select-sm text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="per_page" onchange="this.form.submit()">
                    <?php foreach ($perPageOpts as $opt): ?>
                        <option value="<?= $opt ?>" <?= $perPage === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="skeleton-table" data-skeleton hidden>
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="skeleton-line"></div>
            <?php endfor; ?>
        </div>
        <form class="bulk-delete-form" method="post" action="<?= site_url('admin/activities/bulk-delete') ?>">
            <?= csrf_field() ?>
            <div class="table-responsive">
                <table class="activity-table admin-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input class="form-check-input" type="checkbox" aria-label="Pilih semua" onclick="document.querySelectorAll('.check-activity').forEach(cb => cb.checked = this.checked);">
                            </th>
                             <?php
                             $columns = [
                                 'title' => 'Judul aktivitas',
                                 'activity_date' => 'Tanggal',
                                 'location' => 'Lokasi',
                                 'category' => 'Kategori',
                             ];
                             foreach ($columns as $key => $label):
                                 $dir = ($sortBy === $key && $sortDir === 'asc') ? 'desc' : 'asc';
                                 $params = $queryParams;
                                 $params['sort_by'] = $key;
                                 $params['sort_dir'] = $dir;
                                 $query = http_build_query($params);
                                 $indicator = $sortBy === $key ? ($sortDir === 'asc' ? '<i class="bi bi-arrow-up-short text-slate-500"></i>' : '<i class="bi bi-arrow-down-short text-slate-500"></i>') : '';
                             ?>
                                 <th>
                                     <a href="?<?= $query ?>" class="text-decoration-none d-inline-flex align-items-center gap-1 text-slate-600">
                                         <?= esc($label) ?> <?= $indicator ?>
                                     </a>
                                 </th>
                             <?php endforeach; ?>
                            <th>Deskripsi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                                <tr>
                                    <td>
                                        <input class="form-check-input check-activity" type="checkbox" name="selected_ids[]" value="<?= esc($activity['id']) ?>" aria-label="Pilih aktivitas">
                                    </td>
                                    <td><strong><?= esc($activity['title']) ?></strong></td>
                                    <td><?= esc(date('d M Y', strtotime($activity['activity_date']))) ?></td>
                                    <td><?= esc($activity['location']) ?></td>
                                    <td>
                                        <?php $badgeClass = $categoryColors[$activity['category']] ?? 'badge-soft-slate'; ?>
                                        <span class="badge <?= $badgeClass ?> text-uppercase"><?= esc($activity['category']) ?></span>
                                    </td>
                                    <td class="text-token-secondary text-clamp-2"><?= esc($activity['description']) ?></td>
                                    <td class="text-end">
                                        <a class="icon-btn focus-ring" href="<?= site_url('admin/activities/' . $activity['id'] . '/edit') ?>" aria-label="Edit aktivitas">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="icon-btn danger focus-ring" type="button" data-delete-url="<?= site_url('admin/activities/' . $activity['id'] . '/delete') ?>" aria-label="Hapus aktivitas">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="empty-state">
                                        <img src="https://cdn.jsdelivr.net/gh/alohe/illustrations/undraw-steps.svg" alt="Empty state illustration">
                                        <p class="mb-3">Belum ada data untuk filter saat ini.</p>
                                        <a class="btn btn-primary" href="<?= site_url('admin/activities/create') ?>">Tambah Aktivitas</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="activity-cards">
                <?php if (! empty($activities)): ?>
                    <?php foreach ($activities as $activity): ?>
                        <div class="activity-card">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h5><?= esc($activity['title']) ?></h5>
                                    <div class="meta">
                                        <span><i class="bi bi-calendar"></i> <?= esc(date('d M Y', strtotime($activity['activity_date']))) ?></span>
                                        <span><i class="bi bi-geo-alt"></i> <?= esc($activity['location']) ?></span>
                                    </div>
                                </div>
                                <?php $badgeClass = $categoryColors[$activity['category']] ?? 'badge-soft-slate'; ?>
                                <span class="badge <?= $badgeClass ?> text-uppercase"><?= esc($activity['category']) ?></span>
                            </div>
                                <p class="text-token-secondary mt-2 mb-0"><?= esc($activity['description']) ?></p>
                            <div class="card-actions">
                                <a class="icon-btn" href="<?= site_url('admin/activities/' . $activity['id'] . '/edit') ?>">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="icon-btn danger" type="button" data-delete-url="<?= site_url('admin/activities/' . $activity['id'] . '/delete') ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <img src="https://cdn.jsdelivr.net/gh/alohe/illustrations/undraw-steps.svg" alt="Empty state illustration">
                        <p class="mb-3">Belum ada data untuk filter saat ini.</p>
                        <a class="btn btn-primary" href="<?= site_url('admin/activities/create') ?>">Tambah Aktivitas</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="table-footer">
                <button class="btn btn-outline-danger focus-ring d-flex align-items-center gap-2" type="submit" onclick="return confirm('Hapus data yang dipilih?')">
                    <i class="bi bi-trash3"></i> Hapus Terpilih
                </button>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <form class="d-flex align-items-center gap-2" method="get">
                        <?php foreach ($queryParams as $key => $value): ?>
                            <?php if (is_array($value)): ?>
                                <?php foreach ($value as $v): ?>
                                    <input type="hidden" name="<?= esc($key) ?>[]" value="<?= esc($v) ?>">
                                <?php endforeach; ?>
                            <?php else: ?>
                                <input type="hidden" name="<?= esc($key) ?>" value="<?= esc($value) ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <label class="form-label small mb-0 text-token-muted">Loncat ke halaman</label>
                        <input class="form-control form-control-sm text-slate-900 bg-transparent border border-slate-200 rounded-pill" type="number" min="1" name="page_activities" value="<?= esc($pager->getCurrentPage('activities')) ?>">
                        <button class="btn btn-outline-secondary btn-sm rounded-pill" type="submit">Go</button>
                    </form>
                    <?php
                    // #region agent log
                    @file_put_contents('c:/xampp/htdocs/tugaszakyCI4/.cursor/debug.log', json_encode([
                        'sessionId' => 'debug-session',
                        'runId' => 'admin-fix',
                        'hypothesisId' => 'ACT-VIEW',
                        'location' => 'admin/activities/index.php:pager',
                        'message' => 'Render pager activities',
                        'data' => [
                            'total' => $total ?? null,
                            'queryParams' => $queryParams ?? [],
                        ],
                        'timestamp' => round(microtime(true) * 1000),
                    ]) . PHP_EOL, FILE_APPEND);
                    // #endregion
                    ?>
                    <?= $pager->links('activities', 'query_pager', ['params' => $queryParams]) ?>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="avatar-icon bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <h5 class="mb-1">Hapus aktivitas?</h5>
                    <p class="text-token-muted mb-0">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger" type="button" id="deleteConfirmBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="activityToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<script>
    (() => {
        const filterCard = document.querySelector('[data-filter-card]');
        const filterBody = filterCard?.querySelector('.filter-body');
        const toggleBtn = document.querySelector('[data-filter-toggle]');
        const openMobileBtn = document.querySelector('[data-filter-open]');
        const closeBtns = document.querySelectorAll('[data-filter-close]');
        const categorySelect = document.getElementById('categorySelect');
        const categoryChips = document.getElementById('categoryChips');
        const categoryReset = document.querySelector('[data-chip-reset]');
        const skeleton = document.querySelector('[data-skeleton]');
        const filterForm = document.getElementById('activityFilterForm');
        const toastEl = document.getElementById('activityToast');
        let deleteUrl = null;

        toggleBtn?.addEventListener('click', () => {
            filterBody?.classList.toggle('collapsed');
            const expanded = filterBody && !filterBody.classList.contains('collapsed');
            toggleBtn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            toggleBtn.querySelector('.bi')?.classList.toggle('bi-chevron-down', !expanded);
            toggleBtn.querySelector('.bi')?.classList.toggle('bi-chevron-up', expanded);
        });

        const closeFilter = () => {
            document.body.classList.remove('mobile-filter-open');
        };
        openMobileBtn?.addEventListener('click', () => {
            document.body.classList.add('mobile-filter-open');
        });
        closeBtns.forEach(btn => btn.addEventListener('click', closeFilter));
        document.querySelectorAll('[data-filter-close]').forEach(btn => btn.addEventListener('click', closeFilter));
        document.querySelector('.filter-backdrop')?.addEventListener('click', closeFilter);

        if (categorySelect && categoryChips) {
            const renderCategoryChip = () => {
                categoryChips.innerHTML = '';
                const value = categorySelect.value;
                if (value) {
                    const span = document.createElement('span');
                    span.className = 'chip';
                    span.textContent = categorySelect.options[categorySelect.selectedIndex].textContent;
                    categoryChips.appendChild(span);
                }
            };
            renderCategoryChip();
            categorySelect.addEventListener('change', renderCategoryChip);
            categoryReset?.addEventListener('click', () => {
                categorySelect.selectedIndex = 0;
                renderCategoryChip();
            });
        }

        filterForm?.addEventListener('submit', () => {
            if (skeleton) skeleton.hidden = false;
        });

        document.querySelectorAll('[data-delete-url]').forEach(btn => {
            btn.addEventListener('click', () => {
                deleteUrl = btn.dataset.deleteUrl;
                const modal = new bootstrap.Modal('#deleteConfirmModal');
                modal.show();
                document.getElementById('deleteConfirmBtn').onclick = () => {
                    if (deleteUrl) {
                        window.location.assign(deleteUrl);
                    }
                };
            });
        });

        const toastMessage = <?= json_encode(session('success') ?? session('error') ?? '') ?>;
        if (toastMessage && toastEl) {
            toastEl.classList.toggle('text-bg-danger', Boolean(<?= json_encode((bool) session('error')) ?>));
            toastEl.classList.toggle('text-bg-success', Boolean(<?= json_encode((bool) session('success')) ?>));
            toastEl.querySelector('.toast-body').textContent = toastMessage;
            const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
            toast.show();
        }
    })();
</script>
<?= $this->endSection() ?>
