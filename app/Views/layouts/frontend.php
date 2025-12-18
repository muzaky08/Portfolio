<!doctype html>
<?php
$request        = service('request');
$currentLocale  = $request->getLocale() ?? 'id';
$canonicalUrl   = current_url();
$cssPath        = ENVIRONMENT === 'production' ? 'assets/css/frontend.min.css' : 'assets/css/frontend.css';
$jsPath         = ENVIRONMENT === 'production' ? 'assets/js/frontend.min.js' : 'assets/js/frontend.js';
$metaDescription = $settings['about_summary'] ?? lang('App.about_heading');
$metaKeywords    = $settings['meta_keywords'] ?? 'portfolio, developer';
$analyticsId     = $settings['analytics_measurement_id'] ?? '';
$navItems = [
    'Home'       => site_url('/'),
    'Aktivitas'  => site_url('aktivitas'),
    'Biodata'    => site_url('biodata'),
    'Pendidikan' => site_url('pendidikan'),
];
$agentLogPath = 'c:/xampp/htdocs/tugaszakyCI4/.cursor/debug.log';
if (! is_dir(dirname($agentLogPath))) {
    @mkdir(dirname($agentLogPath), 0775, true);
}
// #region agent log
@file_put_contents($agentLogPath, json_encode([
    'sessionId' => 'debug-session',
    'runId' => 'ui-redesign',
    'hypothesisId' => 'LAYOUT',
    'location' => 'layouts/frontend.php:init',
    'message' => 'Layout render',
    'data' => [
        'uri' => service('request')->getUri()->getPath(),
    ],
    'timestamp' => round(microtime(true) * 1000),
]) . PHP_EOL, FILE_APPEND);
// #endregion
$currentPath = trim($request->getUri()->getPath(), '/');
?>
<html lang="<?= esc($currentLocale) ?>" x-data="publicShell()" x-init="init()" :class="mode === 'dark' ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($pageTitle ?? lang('App.default_title')) ?></title>
    <meta name="description" content="<?= esc($metaDescription) ?>">
    <meta name="keywords" content="<?= esc($metaKeywords) ?>">
    <link rel="canonical" href="<?= esc($canonicalUrl) ?>">
    <meta property="og:title" content="<?= esc($pageTitle ?? lang('App.default_title')) ?>">
    <meta property="og:description" content="<?= esc($metaDescription) ?>">
    <meta property="og:url" content="<?= esc($canonicalUrl) ?>">
    <meta property="og:type" content="website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url($cssPath) ?>" rel="stylesheet">
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <style>
        :root {
            color-scheme: light;
            --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
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
            --color-success: #10b981;
            --color-hover: rgba(79, 70, 229, 0.08);
            --color-active: rgba(79, 70, 229, 0.2);
            --color-focus: rgba(79, 70, 229, 0.35);
            --shadow-card: 0 24px 50px rgba(15, 23, 42, 0.08);
            --radius-xl: 2.5rem;
            --transition-base: all 250ms ease;
        }
        .dark {
            color-scheme: dark;
            --color-bg: #020617;
            --color-surface: #020617;
            --color-surface-elevated: #0f172a;
            --color-text-primary: #f8fafc;
            --color-text-secondary: #94a3b8;
            --color-text-muted: #64748b;
            --color-border-subtle: #1e293b;
            --color-border-strong: #334155;
            --color-primary: #818cf8;
            --color-accent: #22d3ee;
            --color-success: #34d399;
            --color-hover: rgba(129, 140, 248, 0.2);
            --color-active: rgba(129, 140, 248, 0.35);
            --color-focus: rgba(129, 140, 248, 0.45);
            --shadow-card: 0 30px 70px rgba(2, 6, 23, 0.8);
        }
        body {
            font-family: var(--font-sans);
            background: radial-gradient(circle at top, rgba(255,255,255,0.35), transparent 50%), var(--color-bg);
            color: var(--color-text-secondary);
            transition: var(--transition-base);
            min-height: 100vh;
        }
        .theme-shell {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        .glass-panel {
            background: color-mix(in srgb, var(--color-surface) 85%, transparent);
            border: 1px solid var(--color-border-subtle);
            border-radius: 999px;
            box-shadow: var(--shadow-card);
            backdrop-filter: blur(18px);
        }
        .surface-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            transition: var(--transition-base);
        }
        .surface-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px color-mix(in srgb, var(--color-primary) 15%, transparent);
        }
        .surface-elevated {
            background: var(--color-surface-elevated);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
        }
        .badge-soft {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.85rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 999px;
            background: color-mix(in srgb, var(--color-primary) 12%, transparent);
            color: var(--color-primary);
        }
        .section-gap {
            padding: 4rem 0;
        }
        .u-text-primary { color: var(--color-text-primary); }
        .u-text-secondary { color: var(--color-text-secondary); }
        .u-text-secondary a {
            color: inherit;
        }
        .u-text-muted { color: var(--color-text-muted); }
        .u-text-success { color: var(--color-success); }
        .eyebrow {
            font-size: 0.75rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--color-text-muted);
        }
        .btn-primary-brand {
            background: var(--color-primary);
            color: #fff;
            border-radius: 999px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            border: none;
            box-shadow: 0 20px 35px rgba(79, 70, 229, 0.25);
            transition: var(--transition-base);
        }
        .btn-primary-brand:hover { transform: translateY(-2px); box-shadow: 0 25px 45px rgba(79,70,229,.3); }
        .btn-ghost {
            border-radius: 999px;
            border: 1px solid var(--color-border-subtle);
            color: var(--color-text-primary);
            padding: 0.65rem 1.5rem;
            transition: var(--transition-base);
        }
        .btn-ghost:hover { border-color: var(--color-primary); color: var(--color-primary); }
        .form-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .form-field label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-text-secondary);
        }
        .form-field input,
        .form-field select,
        .form-field textarea {
            background: color-mix(in srgb, var(--color-surface) 92%, transparent);
            border: 1px solid var(--color-border-subtle);
            border-radius: 1.25rem;
            color: var(--color-text-primary);
            padding: 0.85rem 1rem;
            transition: var(--transition-base);
        }
        .form-field select {
            appearance: none;
            -webkit-appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, var(--color-text-muted) 50%), linear-gradient(135deg, var(--color-text-muted) 50%, transparent 50%);
            background-position: calc(100% - 16px) calc(50% - 3px), calc(100% - 11px) calc(50% - 3px);
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
        }
        .form-field select option {
            background: var(--color-surface);
            color: var(--color-text-primary);
        }
        .form-field input:focus,
        .form-field select:focus,
        .form-field textarea:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px var(--color-focus);
            outline: none;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @media (max-width: 768px) {
            .theme-shell {
                padding: 0 1rem;
            }
            .section-gap {
                padding: 2.5rem 0;
            }
            .surface-card,
            .surface-elevated {
                border-radius: 1.5rem;
                padding: 1.5rem;
            }
            .glass-panel {
                border-radius: 1.5rem;
            }
            .hero-cta,
            .contact-actions {
                flex-direction: column;
                align-items: stretch;
            }
            .hero-cta .btn-primary-brand,
            .hero-cta .btn-ghost,
            .contact-actions .btn-primary-brand {
                width: 100%;
                justify-content: center;
            }
        }
        [data-animate] {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .6s ease, transform .6s ease;
        }
        [data-animate].is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        @media (prefers-reduced-motion: reduce) {
            [data-animate] {
                transition: none;
            }
        }
    </style>
    <?php if (! empty($analyticsId)): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= esc($analyticsId) ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?= esc($analyticsId) ?>');
        </script>
    <?php endif; ?>
</head>
<body class="min-h-screen bg-transparent text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(79,70,229,0.12),_transparent_45%)] dark:bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.18),_transparent_50%)]"></div>
        <header class="sticky top-0 z-30 px-4 pt-4">
            <div class="theme-shell">
                <div class="glass-panel relative flex h-[72px] w-full items-center px-6 py-3">
                    <a class="text-lg font-semibold u-text-primary transition hover:text-[var(--color-primary)]" href="<?= site_url('/') ?>">
                    <?= esc($settings['hero_headline'] ?? lang('App.default_title')) ?>
                </a>
                    <nav class="mx-auto hidden gap-6 text-sm font-semibold uppercase tracking-[0.2em] u-text-muted lg:flex">
                    <?php foreach ($navItems as $label => $url): ?>
                        <?php $isActive = $currentPath === trim(parse_url($url, PHP_URL_PATH), '/'); ?>
                        <a class="relative pb-1 text-sm transition <?= $isActive ? 'text-[var(--color-primary)] after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:rounded-full after:bg-[var(--color-primary)]' : 'u-text-muted hover:text-[var(--color-primary)]' ?>" href="<?= $url ?>">
                            <?= esc($label) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
                    <div class="ms-auto flex items-center gap-2">
                        <button class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[var(--color-border-subtle)] u-text-secondary transition hover:border-[var(--color-primary)] hover:text-[var(--color-primary)]" type="button" @click="toggleMode" :aria-label="mode === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'">
                        <i :data-lucide="mode === 'dark' ? 'sun' : 'moon'" class="h-4 w-4"></i>
                    </button>
                    <div class="relative" x-data="{ open:false }">
                        <button class="inline-flex items-center rounded-full border border-[var(--color-border-subtle)] px-3 py-1 text-sm font-semibold u-text-secondary transition hover:border-[var(--color-primary)] hover:text-[var(--color-primary)]" @click="open = !open" type="button">
                            <?= esc(strtoupper($currentLocale)) ?>
                            <i data-lucide="chevron-down" class="ms-1 h-4 w-4"></i>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-40 rounded-2xl border border-[var(--color-border-subtle)] bg-[var(--color-surface)] p-2 shadow-card">
                            <a class="block rounded-xl px-3 py-2 text-sm font-medium u-text-secondary transition hover:bg-[var(--color-hover)]" href="<?= site_url('lang/id') ?>">Bahasa Indonesia</a>
                            <a class="block rounded-xl px-3 py-2 text-sm font-medium u-text-secondary transition hover:bg-[var(--color-hover)]" href="<?= site_url('lang/en') ?>">English</a>
                        </div>
                    </div>
                    <a class="inline-flex items-center gap-2 rounded-full border border-transparent bg-[var(--color-primary)] px-4 py-2 text-sm font-semibold text-white shadow-[0_15px_35px_rgba(79,70,229,0.3)] transition hover:-translate-y-0.5" href="<?= site_url('admin/login') ?>">
                        <i data-lucide="log-in" class="h-4 w-4"></i> Masuk
                    </a>
                </div>
                </div>
            </div>
        </header>
        <main class="relative z-10">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="<?= base_url($jsPath) ?>"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            window.publicShell = () => ({
                mode: 'light',
                init() {
                    const stored = localStorage.getItem('portfolio-theme');
                    if (stored) {
                        this.mode = stored;
                    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        this.mode = 'dark';
                    }
                    this.updateTheme();
                },
                toggleMode() {
                    this.mode = this.mode === 'dark' ? 'light' : 'dark';
                    localStorage.setItem('portfolio-theme', this.mode);
                    this.updateTheme();
                },
                updateTheme() {
                    document.documentElement.classList.toggle('dark', this.mode === 'dark');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
