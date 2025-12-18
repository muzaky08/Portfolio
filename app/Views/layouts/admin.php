<!doctype html>
<html lang="<?= esc(service('request')->getLocale() ?? 'id') ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($pageTitle ?? 'Admin Panel') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#4f46e5',
                        'brand-soft': '#eef2ff',
                        'brand-muted': '#a5b4fc',
                        'surface-muted': '#f5f6fb',
                        'slate-900': '#0f172a',
                        'slate-600': '#64748b',
                        'slate-200': '#e2e8f0',
                        'emerald-soft': '#ecfdf5',
                        'amber-soft': '#fffbeb',
                    },
                    fontFamily: {
                        inter: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: {
                        shell: '1.5rem',
                    },
                    boxShadow: {
                        shell: '0 20px 45px rgba(15,23,42,.08)',
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        (function () {
            const stored = localStorage.getItem('portfolio-theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <style>
        :root {
            color-scheme: light;
            --font-sans: 'Inter', 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            --color-bg: #f8fafc;
            --color-surface: #ffffff;
            --color-surface-elevated: #eef2ff;
            --color-text-primary: #0f172a;
            --color-text-secondary: #475569;
            --color-text-muted: #94a3b8;
            --color-border-subtle: #e2e8f0;
            --color-border-strong: #cbd5f5;
            --color-primary: #4f46e5;
            --color-accent: #0ea5e9;
            --color-success: #22c55e;
            --color-warning: #fbbf24;
            --shadow-card: 0 30px 65px rgba(15, 23, 42, 0.08);
            --shadow-soft: 0 18px 40px rgba(15, 23, 42, 0.07);
            --radius-lg: 1.5rem;
            --radius-md: 1rem;
            --radius-pill: 999px;
            --shell-max: 1280px;
            --spacing-shell: 2.5rem;
            --transition-base: all 220ms ease;
        }

        .dark {
            color-scheme: dark;
            --color-bg: #020617;
            --color-surface: #030a1c;
            --color-surface-elevated: #0f172a;
            --color-text-primary: #f8fafc;
            --color-text-secondary: #cbd5f5;
            --color-text-muted: #7c8ca8;
            --color-border-subtle: #1e293b;
            --color-border-strong: #334155;
            --color-primary: #818cf8;
            --color-accent: #22d3ee;
            --color-success: #34d399;
            --color-warning: #facc15;
            --shadow-card: 0 30px 60px rgba(2, 6, 23, 0.65);
            --shadow-soft: 0 18px 45px rgba(2, 6, 23, 0.55);
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at 15% -20%, rgba(79, 70, 229, 0.15), transparent 45%), var(--color-bg);
            color: var(--color-text-secondary);
            font-family: var(--font-sans);
            line-height: 1.6;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .admin-shell {
            max-width: var(--shell-max);
            margin: 0 auto;
            padding-left: clamp(1rem, 2vw, 1.75rem);
            padding-right: clamp(1rem, 2vw, 1.75rem);
        }

        .glass-nav {
            border-radius: var(--radius-lg);
            border: 1px solid var(--color-border-subtle);
            background: color-mix(in srgb, var(--color-surface) 90%, transparent);
            box-shadow: var(--shadow-soft);
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: -0.3px;
            color: var(--color-text-primary);
        }

        .navbar-search {
            max-width: 520px;
        }

        .navbar-search .form-control {
            background-color: color-mix(in srgb, var(--color-surface) 88%, transparent);
            border: 1px solid transparent;
            border-radius: var(--radius-pill);
            padding-left: 3rem;
            height: 46px;
            transition: var(--transition-base);
        }

        .navbar-search .form-control:focus {
            background-color: var(--color-surface);
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-primary) 25%, transparent);
        }

        .navbar-search .search-icon {
            position: absolute;
            top: 50%;
            left: 1.25rem;
            transform: translateY(-50%);
            color: var(--color-text-muted);
            font-size: 1rem;
        }

        .user-pill {
            background: color-mix(in srgb, var(--color-surface) 92%, transparent);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-pill);
            padding: 0.5rem 1rem;
            transition: var(--transition-base);
        }

        .avatar-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.9rem;
            background: color-mix(in srgb, var(--color-primary) 18%, transparent);
            color: var(--color-primary);
            display: grid;
            place-items: center;
            font-size: 1.1rem;
        }

        .sidebar {
            min-width: 240px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--color-border-subtle);
            background: var(--color-surface);
            box-shadow: var(--shadow-card);
            position: sticky;
            top: 1.5rem;
        }

        .sidebar .sidebar-heading {
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.25em;
            color: var(--color-text-muted);
        }

        .sidebar .nav-link {
            color: var(--color-text-secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1rem;
            border-radius: 0.95rem;
            transition: var(--transition-base);
        }

        .sidebar .nav-link .sidebar-icon {
            width: 36px;
            height: 36px;
            border-radius: 0.85rem;
            background: color-mix(in srgb, var(--color-border-subtle) 35%, transparent);
            display: grid;
            place-items: center;
            color: var(--color-text-secondary);
            transition: var(--transition-base);
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: color-mix(in srgb, var(--color-primary) 10%, transparent);
            color: var(--color-primary);
        }

        .sidebar .nav-link.active .sidebar-icon,
        .sidebar .nav-link:hover .sidebar-icon {
            background: color-mix(in srgb, var(--color-primary) 22%, transparent);
            color: var(--color-primary);
        }

        .dashboard-canvas {
            padding-top: 1rem;
            padding-bottom: 2rem;
        }

        .card-shell {
            background: var(--color-surface);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            transition: var(--transition-base);
        }

        .card-shell:hover {
            transform: translateY(-2px);
            box-shadow: 0 35px 70px color-mix(in srgb, var(--color-primary) 12%, transparent);
        }

        .section-label {
            font-size: 0.75rem;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: var(--color-text-muted);
        }

        .section-title {
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--color-text-primary);
        }

        .section-subtext {
            color: var(--color-text-secondary);
            font-size: 0.95rem;
        }

        .text-token-primary,
        .text-token-secondary,
        .text-token-muted {
            transition: color var(--transition-base);
        }

        .text-token-primary {
            color: var(--color-text-primary) !important;
        }

        .text-token-secondary {
            color: var(--color-text-secondary) !important;
        }

        .text-token-muted {
            color: var(--color-text-muted) !important;
        }

        .list-empty {
            padding: 1.5rem;
            text-align: center;
            color: var(--color-text-muted);
            border: 1px dashed var(--color-border-subtle);
            border-radius: var(--radius-lg);
        }

        .admin-page {
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
            padding-bottom: 1rem;
        }

        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table thead th {
            padding: 0.85rem 1rem;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-text-muted);
            background: color-mix(in srgb, var(--color-surface-elevated) 70%, transparent);
            border-bottom: 1px solid var(--color-border-subtle);
        }

        .admin-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid color-mix(in srgb, var(--color-border-subtle) 60%, transparent);
        }

        .admin-table tbody tr:hover {
            background: color-mix(in srgb, var(--color-primary) 6%, transparent);
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: var(--radius-pill);
            padding: 0.25rem 0.85rem;
            font-size: 0.75rem;
            font-weight: 600;
            background: color-mix(in srgb, var(--color-primary) 12%, transparent);
            color: var(--color-primary);
        }

        .chip-muted {
            background: color-mix(in srgb, var(--color-text-muted) 20%, transparent);
            color: var(--color-text-primary);
        }

        .badge-soft {
            border-radius: var(--radius-pill);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.85rem;
            background: color-mix(in srgb, var(--color-primary) 12%, transparent);
            color: var(--color-primary);
        }

        .badge-soft.success {
            background: color-mix(in srgb, var(--color-success) 18%, transparent);
            color: var(--color-success);
        }

        .badge-soft.warning {
            background: color-mix(in srgb, var(--color-warning) 22%, transparent);
            color: var(--color-warning);
        }

        .theme-toggle {
            width: 46px;
            height: 46px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--color-border-subtle);
            background: color-mix(in srgb, var(--color-surface) 90%, transparent);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-secondary);
            transition: var(--transition-base);
        }

        .theme-toggle:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .admin-form-grid {
            display: grid;
            gap: 1.25rem;
        }

        .admin-form-grid.two-col {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .admin-summary {
            font-size: 0.9rem;
            color: var(--color-text-secondary);
        }

        #adminSearchPanel {
            position: absolute;
            display: none;
            z-index: 1020;
            border-radius: 1rem;
            border: 1px solid var(--color-border-subtle);
            overflow: hidden;
            background: var(--color-surface);
            box-shadow: var(--shadow-soft);
        }

        #adminSearchPanel.show {
            display: block;
        }

    #adminSearchResults {
        max-height: 300px;
        overflow-y: auto;
    }

    .search-panel-head,
    .search-panel-body {
        background: var(--color-surface);
    }

        .bg-brand {
            background-color: var(--color-primary) !important;
        }

        .bg-brand-soft {
            background-color: color-mix(in srgb, var(--color-primary) 15%, transparent) !important;
        }

        .bg-brand-soft\/80 {
            background-color: color-mix(in srgb, var(--color-primary) 12%, transparent 20%) !important;
        }

        .text-brand {
            color: var(--color-primary) !important;
        }

        .border-brand {
            border-color: var(--color-primary) !important;
        }

        .bg-emerald-soft,
        .bg-emerald-soft\/80 {
            background-color: color-mix(in srgb, var(--color-success) 16%, transparent) !important;
        }

        .bg-amber-soft,
        .bg-amber-soft\/80 {
            background-color: color-mix(in srgb, var(--color-warning) 20%, transparent) !important;
        }

        .bg-slate-50 {
            background-color: color-mix(in srgb, var(--color-surface) 94%, transparent) !important;
        }

        .bg-slate-50\/80 {
            background-color: color-mix(in srgb, var(--color-surface) 90%, transparent) !important;
        }

        .bg-slate-50\/90 {
            background-color: color-mix(in srgb, var(--color-surface) 95%, transparent) !important;
        }

        .bg-slate-100,
        .bg-slate-100\/60 {
            background-color: color-mix(in srgb, var(--color-surface) 80%, transparent) !important;
        }

        .border-slate-100 {
            border-color: var(--color-border-subtle) !important;
        }

        .border-slate-200 {
            border-color: color-mix(in srgb, var(--color-border-subtle) 80%, var(--color-border-strong) 20%) !important;
        }

        .text-slate-900,
        .text-slate-800 {
            color: var(--color-text-primary) !important;
        }

        .text-slate-700,
        .text-slate-600 {
            color: var(--color-text-secondary) !important;
        }

        .text-slate-500,
        .text-slate-400 {
            color: var(--color-text-muted) !important;
        }

        @media (max-width: 991.98px) {
            .user-pill {
                width: 100%;
                border-radius: 1rem;
            }

            .sidebar {
                position: static;
            }
        }
    </style>
</head>
<body>
<?php $userName = session('user_name') ?: 'Admin'; ?>
<nav class="py-4">
    <div class="admin-shell">
        <div class="glass-nav navbar navbar-expand-lg px-4 py-3">
            <div class="w-100 d-flex align-items-center gap-3 flex-wrap">
                <a class="navbar-brand" href="<?= site_url('admin') ?>">Portfolio CMS</a>
                <form class="navbar-search flex-grow-1 order-3 order-lg-2 position-relative w-100" autocomplete="off">
                    <i class="bi bi-search search-icon"></i>
                    <input id="adminSearchInput" type="search" class="form-control" placeholder="Cari aktivitas, proyek, pendidikan..." data-search-url="<?= site_url('admin/search') ?>">
                    <div id="adminSearchPanel" class="dropdown-menu w-100 mt-1">
                        <div class="px-3 py-2 border-bottom search-panel-head">
                            <div class="small text-token-muted">Riwayat</div>
                            <div id="adminSearchHistory" class="small"></div>
                        </div>
                        <div id="adminSearchResults" class="max-h-300 overflow-auto search-panel-body"></div>
                    </div>
                </form>
                <div class="d-flex align-items-center gap-2 order-2 order-lg-3 ms-lg-auto">
                    <button class="theme-toggle" type="button" data-theme-toggle aria-label="Toggle theme">
                        <i class="bi bi-moon"></i>
                    </button>
                    <div class="user-pill d-flex align-items-center gap-3">
                        <div class="avatar-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <div class="text-token-muted small">Masuk sebagai</div>
                            <div class="fw-semibold text-slate-900"><?= esc($userName) ?></div>
                        </div>
                        <a class="btn btn-outline-danger btn-sm px-3" href="<?= site_url('admin/logout') ?>">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="admin-shell pb-5">
    <div class="row g-4 g-xl-5">
        <aside class="col-lg-3 col-xl-3">
            <div class="sidebar p-4">
                <div class="sidebar-heading mb-3">Navigasi utama</div>
                <?php $menu = [
                    ['label' => 'Dashboard',     'url' => 'admin/dashboard',     'icon' => 'bi-speedometer2'],
                    ['label' => 'Activities',    'url' => 'admin/activities',    'icon' => 'bi-calendar-check'],
                    ['label' => 'Projects',      'url' => 'admin/projects',      'icon' => 'bi-layers'],
                    ['label' => 'Skills',        'url' => 'admin/skills',        'icon' => 'bi-lightning-charge'],
                    ['label' => 'Educations',    'url' => 'admin/educations',    'icon' => 'bi-mortarboard'],
                    ['label' => 'Experiences',   'url' => 'admin/experiences',   'icon' => 'bi-briefcase'],
                    ['label' => 'Biodata',       'url' => 'admin/profile',       'icon' => 'bi-person-lines-fill'],
                    ['label' => 'Settings',      'url' => 'admin/settings',      'icon' => 'bi-gear'],
                    ['label' => 'Messages',      'url' => 'admin/messages',      'icon' => 'bi-envelope'],
                    ['label' => 'Activity Logs', 'url' => 'admin/activity-logs', 'icon' => 'bi-clock-history'],
                    ['label' => 'Backups',       'url' => 'admin/backups',       'icon' => 'bi-shield-lock'],
                ]; ?>
                <?php $current = trim(uri_string() ?? '', '/'); ?>
                <div class="nav flex-column gap-1">
                    <?php foreach ($menu as $item): ?>
                        <?php $path = trim($item['url'], '/'); ?>
                        <?php $active = str_starts_with($current, $path); ?>
                        <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= site_url($item['url']) ?>">
                            <span class="sidebar-icon">
                                <i class="bi <?= esc($item['icon']) ?>"></i>
                            </span>
                            <span class="flex-grow-1"><?= esc($item['label']) ?></span>
                            <?php if ($active): ?>
                                <i class="bi bi-chevron-right small"></i>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>
        <main class="col-lg-9 col-xl-9">
            <?php if (session('success')): ?>
                <div class="alert alert-success"><?= esc(session('success')) ?></div>
            <?php endif; ?>
            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= esc(session('error')) ?></div>
            <?php endif; ?>
            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ((array) session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="<?= base_url('assets/js/admin-search.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
            const toggleBtn = document.querySelector('[data-theme-toggle]');
            const toggleIcon = toggleBtn?.querySelector('i');
            const currentMode = () => document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            const syncIcon = () => {
                if (!toggleIcon) return;
                const mode = currentMode();
                toggleIcon.classList.remove('bi-sun', 'bi-moon');
                toggleIcon.classList.add(mode === 'dark' ? 'bi-sun' : 'bi-moon');
            };
            syncIcon();
            toggleBtn?.addEventListener('click', () => {
                const next = currentMode() === 'dark' ? 'light' : 'dark';
                document.documentElement.classList.toggle('dark', next === 'dark');
                localStorage.setItem('portfolio-theme', next);
                syncIcon();
            });
        });
    </script>
</body>
</html>
