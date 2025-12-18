<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center bg-light" style="min-height:100vh;">
    <div class="card shadow-sm" style="min-width:360px;">
        <div class="card-body p-4">
            <h1 class="h4 mb-3 text-center">Portfolio CMS</h1>
            <?php if (session('success')): ?>
                <div class="alert alert-success"><?= esc(session('success')) ?></div>
            <?php endif; ?>
            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= esc(session('error')) ?></div>
            <?php endif; ?>
            <form action="<?= site_url('admin/login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Email atau Username</label>
                    <input class="form-control" name="identity" value="<?= old('identity') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ingat saya selama 30 hari</label>
                </div>
                <button class="btn btn-primary w-100" type="submit">Masuk</button>
            </form>
            <p class="text-center mt-3 mb-0">
                Belum punya akun? <a href="<?= site_url('admin/register') ?>">Daftar sekarang</a>
            </p>
        </div>
    </div>
</body>
</html>

