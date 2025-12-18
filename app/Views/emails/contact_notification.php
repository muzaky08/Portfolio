<h2>Pesan Baru dari Portofolio</h2>
<p>Detail pengirim:</p>
<ul>
    <li><strong>Nama:</strong> <?= esc($payload['name']) ?></li>
    <li><strong>Email:</strong> <?= esc($payload['email']) ?></li>
    <li><strong>Subjek:</strong> <?= esc($payload['subject'] ?? '-') ?></li>
</ul>
<p><strong>Pesan:</strong></p>
<p><?= nl2br(esc($payload['message'])) ?></p>
