<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center bg-light" style="min-height:100vh;">
    <div class="card shadow-sm" style="min-width:400px;">
        <div class="card-body p-4">
            <h1 class="h4 mb-3 text-center">Buat Akun Admin</h1>
            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?= site_url('admin/register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input class="form-control" name="full_name" value="<?= old('full_name') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input class="form-control" name="username" value="<?= old('username') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="<?= old('email') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input class="form-control" type="password" name="password_confirm" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">Daftar</button>
            </form>
            <p class="text-center mt-3 mb-0">
                Sudah punya akun? <a href="<?= site_url('admin/login') ?>">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
