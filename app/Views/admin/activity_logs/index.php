<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Keamanan</p>
                <h1 class="section-title text-2xl mb-1">Activity Logs</h1>
                <p class="section-subtext mb-0">Catatan otomatis setiap aksi admin, lengkap untuk audit dan troubleshooting.</p>
            </div>
        </div>
    </section>
    <section class="card-shell p-5">
        <form class="admin-form-grid two-col" method="get">
            <div>
                <label class="form-label small text-token-muted">Keyword</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="keyword" placeholder="Action atau deskripsi" value="<?= esc($filters['keyword'] ?? '') ?>">
            </div>
            <div>
                <label class="form-label small text-token-muted">User</label>
                <select class="form-select text-slate-900 bg-transparent border border-slate-200 rounded-pill" name="user_id">
                    <option value="">Semua</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= esc($user['id']) ?>" <?= (string) ($filters['user_id'] ?? '') === (string) $user['id'] ? 'selected' : '' ?>>
                            <?= esc($user['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label small text-token-muted">Dari</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" type="date" name="start_date" value="<?= esc($filters['start_date'] ?? '') ?>">
            </div>
            <div>
                <label class="form-label small text-token-muted">Sampai</label>
                <input class="form-control text-slate-900 bg-transparent border border-slate-200 rounded-pill" type="date" name="end_date" value="<?= esc($filters['end_date'] ?? '') ?>">
            </div>
            <div class="d-flex align-items-end justify-content-end gap-2 flex-wrap">
                <input type="hidden" name="per_page" value="<?= esc($perPage) ?>">
                <button class="btn btn-outline-secondary rounded-pill" type="button" onclick="window.location='<?= site_url('admin/activity-logs') ?>'">Reset</button>
                <button class="btn btn-primary rounded-pill" type="submit">Filter</button>
            </div>
        </form>
    </section>
    <section class="card-shell p-0">
        <div class="px-4 pt-4 pb-2 d-flex flex-wrap justify-content-between gap-3 align-items-center">
            <div class="text-token-muted small">Menampilkan <?= $rangeStart ?> - <?= $rangeEnd ?> dari <?= $total ?> log</div>
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
                        <th style="width: 200px;">Waktu</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td class="fw-semibold text-token-primary"><?= esc(date('d M Y H:i', strtotime($log['created_at']))) ?></td>
                                <td class="text-token-secondary"><?= esc($log['user_name'] ?? 'System') ?></td>
                                <td>
                                    <span class="chip chip-muted text-uppercase"><?= esc($log['action']) ?></span>
                                </td>
                                <td class="text-token-secondary"><?= esc($log['description']) ?></td>
                                <td class="text-token-muted small"><?= esc($log['ip_address'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-token-muted py-4">Belum ada log.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-transparent border-0 pt-3">
            <?= $pager->links('activity_logs', 'query_pager', ['params' => $queryParams]) ?>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
