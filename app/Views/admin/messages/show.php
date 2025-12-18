<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="admin-page">
    <section class="card-shell p-6">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <p class="section-label">Pesan masuk</p>
                <h1 class="section-title text-2xl mb-1"><?= esc($message['subject'] ?? 'Pesan') ?></h1>
                <p class="section-subtext mb-0">Dari <?= esc($message['name']) ?> (<?= esc($message['email']) ?>) &middot; <?= esc($message['created_at'] ? date('d M Y H:i', strtotime($message['created_at'])) : '-') ?></p>
            </div>
            <a class="btn btn-outline-secondary rounded-pill" href="<?= site_url('admin/messages') ?>">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
    <section class="card-shell p-5">
        <article class="text-token-secondary">
            <?= nl2br(esc($message['message'])) ?>
        </article>
        <div class="d-flex justify-content-end mt-4">
            <form action="<?= site_url('admin/messages/' . $message['id'] . '/delete') ?>" method="post">
                <?= csrf_field() ?>
                <button class="btn btn-outline-danger rounded-pill" onclick="return confirm('Hapus pesan?')">Hapus Pesan</button>
            </form>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

