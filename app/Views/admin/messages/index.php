<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Pesan</p>
                <h1 class="section-title text-2xl mb-1">Pesan masuk</h1>
                <p class="section-subtext mb-0">Pantau dan respon pesan dari formulir kontak publik.</p>
            </div>
        </div>
    </section>
    <section class="card-shell p-0">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pengirim</th>
                    <th>Subjek</th>
                    <th>Tanggal</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td>
                            <div class="fw-semibold text-slate-900"><?= esc($message['name']) ?></div>
                            <div class="text-token-muted small"><?= esc($message['email']) ?></div>
                        </td>
                        <td class="text-token-secondary"><?= esc($message['subject']) ?></td>
                        <td class="text-token-secondary"><?= esc($message['created_at'] ? date('d M Y H:i', strtotime($message['created_at'])) : '-') ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary rounded-pill" href="<?= site_url('admin/messages/' . $message['id']) ?>">Detail</a>
                            <form action="<?= site_url('admin/messages/' . $message['id'] . '/delete') ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus pesan?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="card-footer bg-transparent border-0 pt-3">
            <?= $pager->links() ?>
        </div>
    </section>
</div>
<?= $this->endSection() ?>
