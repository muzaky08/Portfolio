<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php
    $projects = $latestProjects ?? [];
    $messages = $latestMessages ?? [];
    $totalMessages = $messageCount ?? 0;
    $unreadMessages = $unreadMessages ?? 0;
    $handledMessages = max(0, $totalMessages - $unreadMessages);
    $stats = [
        [
            'label' => 'Projects',
            'value' => $projectCount ?? 0,
            'meta'  => 'Aktif bulan ini',
            'icon'  => 'layout-dashboard',
            'accent' => 'bg-brand-soft text-brand'
        ],
        [
            'label' => 'Skills',
            'value' => $skillCount ?? 0,
            'meta'  => 'Terverifikasi',
            'icon'  => 'sparkles',
            'accent' => 'bg-emerald-soft text-emerald-600'
        ],
        [
            'label' => 'Experiences',
            'value' => $experienceCount ?? 0,
            'meta'  => 'Riwayat profesional',
            'icon'  => 'briefcase',
            'accent' => 'bg-amber-soft text-amber-600'
        ],
        [
            'label' => 'Messages',
            'value' => $totalMessages,
            'meta'  => $unreadMessages ? $unreadMessages . ' belum dibaca' : 'Semua terbalas',
            'icon'  => 'inbox',
            'accent' => 'bg-brand-soft text-brand'
        ],
    ];
    $insights = [
        [
            'label' => 'Progres proyek tahunan',
            'value' => $projectCount ?? 0,
            'target' => 12,
            'tone'  => 'bg-brand-soft',
        ],
        [
            'label' => 'Keaktifan skill',
            'value' => $skillCount ?? 0,
            'target' => 10,
            'tone'  => 'bg-emerald-soft',
        ],
        [
            'label' => 'Engagement pesan',
            'value' => $handledMessages,
            'target' => max(1, $totalMessages),
            'tone'  => 'bg-amber-soft',
        ],
    ];
?>
<style>
    .line-clamp-2 { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; overflow:hidden; }
    [x-cloak] { display:none !important; }
</style>
<!-- Dashboard Canvas -->
<div x-data="dashboardPage()" x-init="init()" class="dashboard-canvas px-2 sm:px-4 lg:px-0 py-4">
    <div class="mx-auto flex max-w-[1280px] flex-col gap-8">
        <!-- Header Section -->
        <section class="card-shell p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="section-label">Dasbor utama</p>
                    <h1 class="section-title text-2xl">Selamat datang kembali, <?= esc(session('user_name') ?? 'Admin') ?></h1>
                    <p class="section-subtext text-sm">Pantau aktivitas penting portofolio Anda dengan grid sistem premium yang nyaman digunakan sepanjang hari.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-brand hover:text-brand" href="<?= site_url('admin/projects') ?>">
                        <i data-lucide="layout-grid" class="h-4 w-4"></i>
                        Lihat Semua Proyek
                    </a>
                    <a class="inline-flex items-center gap-2 rounded-full bg-brand px-5 py-2 text-sm font-semibold text-white shadow-[0_18px_35px_rgba(79,70,229,0.3)] transition hover:-translate-y-0.5" href="<?= site_url('admin/projects/create') ?>">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Tambah Proyek
                    </a>
                </div>
            </div>
        </section>
        <!-- Stats Grid -->
        <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            <?php foreach ($stats as $stat): ?>
                <article class="card-shell p-5 transition duration-300 hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="section-label text-[0.7rem]"><?= esc($stat['label']) ?></p>
                            <p class="mt-3 text-3xl font-semibold text-slate-900"><?= esc($stat['value']) ?></p>
                            <p class="text-sm text-slate-500"><?= esc($stat['meta']) ?></p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl <?= esc($stat['accent']) ?>">
                            <i data-lucide="<?= esc($stat['icon']) ?>" class="h-5 w-5"></i>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
        <!-- Main + Sidebar Grid -->
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-12">
            <!-- Main Content -->
            <div class="space-y-6 xl:col-span-8">
                <!-- Recent Projects -->
                <article class="card-shell p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="section-label">Aktivitas</p>
                            <h2 class="section-title text-xl">Proyek terbaru</h2>
                        </div>
                        <a class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-brand hover:text-brand" href="<?= site_url('admin/projects') ?>">
                            Kelola proyek
                            <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                    <div x-show="loading" class="mt-6 space-y-4" aria-hidden="true">
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <div class="animate-pulse rounded-2xl bg-slate-100/60 px-4 py-5"></div>
                        <?php endfor; ?>
                    </div>
                    <div x-show="!loading" x-cloak class="mt-6 space-y-4">
                        <?php if (! empty($projects)): ?>
                            <?php foreach ($projects as $project): ?>
                                <div class="flex flex-col gap-2 rounded-2xl border border-slate-100 px-4 py-4 transition duration-300 hover:-translate-y-0.5 hover:border-brand/40">
                                    <div class="flex flex-wrap items-center justify-between gap-3">
                                        <div>
                                            <p class="text-base font-semibold text-slate-900"><?= esc($project['title']) ?></p>
                                            <p class="text-sm text-slate-500"><?= esc($project['client'] ?? 'Internal team') ?></p>
                                        </div>
                                        <span class="rounded-full bg-brand-soft px-3 py-1 text-xs font-semibold text-brand"><?= esc($project['status'] ?? 'Aktif') ?></span>
                                    </div>
                                    <?php if (! empty($project['summary'])): ?>
                                        <p class="text-sm text-slate-500 line-clamp-2"><?= esc($project['summary']) ?></p>
                                    <?php endif; ?>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400">
                                        <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="h-3.5 w-3.5"></i><?= esc(! empty($project['created_at']) ? date('d M Y', strtotime($project['created_at'])) : 'Terjadwal') ?></span>
                                        <?php if (! empty($project['tag'])): ?>
                                            <span class="inline-flex items-center gap-1"><i data-lucide="tag" class="h-3.5 w-3.5"></i><?= esc($project['tag']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="flex flex-col items-center gap-3 rounded-2xl border border-dashed border-slate-200 bg-slate-50/80 px-6 py-10 text-center">
                                <img src="https://cdn.jsdelivr.net/gh/alohe/illustrations/undraw-scrum.svg" class="h-32" alt="Empty projects illustration">
                                <p class="text-sm text-slate-500">Belum ada proyek baru. Ayo mulai inisiatif berikutnya!</p>
                                <a class="inline-flex items-center gap-2 rounded-full bg-brand px-5 py-2 text-sm font-semibold text-white" href="<?= site_url('admin/projects/create') ?>">
                                    <i data-lucide="plus" class="h-4 w-4"></i> Tambah proyek
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
                <!-- Insights -->
                <article class="card-shell p-6">
                    <div class="flex flex-col gap-2">
                        <p class="section-label">Analitik</p>
                        <h2 class="section-title text-xl">Insight portofolio</h2>
                        <p class="section-subtext text-sm">Progress bar memberikan gambaran cepat pencapaian tahunan.</p>
                    </div>
                    <div class="mt-6 space-y-5">
                        <?php foreach ($insights as $insight): ?>
                            <?php $target = max(1, $insight['target']); $progress = min(100, ($target ? ($insight['value'] / $target) * 100 : 0)); ?>
                            <div class="rounded-2xl border border-slate-100 p-4">
                                <div class="flex items-center justify-between text-sm">
                                    <div>
                                        <p class="font-medium text-slate-800"><?= esc($insight['label']) ?></p>
                                        <p class="text-slate-400">Target <?= esc($insight['target']) ?></p>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900"><?= esc($insight['value']) ?></span>
                                </div>
                                <div class="mt-3 h-2.5 rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-brand" style="width: <?= esc((int) $progress) ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            </div>
            <!-- Sidebar -->
            <aside class="space-y-6 xl:col-span-4">
                <!-- Latest Messages -->
                <article class="card-shell p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="section-label">Inbox</p>
                            <h2 class="section-title text-xl">Pesan terbaru</h2>
                        </div>
                        <a class="text-sm font-semibold text-brand" href="<?= site_url('admin/messages') ?>">Lihat semua</a>
                    </div>
                    <div class="mt-4 space-y-4">
                        <?php if (! empty($messages)): ?>
                            <?php foreach ($messages as $message): ?>
                                <a class="group block rounded-2xl border border-slate-100 p-4 transition duration-300 hover:-translate-y-0.5 hover:border-brand/40" href="<?= site_url('admin/messages/' . $message['id']) ?>">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                        <p class="text-base font-semibold text-slate-900"><?= esc($message['name']) ?></p>
                                        <p class="text-sm text-slate-400"><?= esc($message['email'] ?? 'Pengirim tidak diketahui') ?></p>
                                        </div>
                                        <span class="text-xs text-slate-400"><?= esc(! empty($message['created_at']) ? date('d M Y', strtotime($message['created_at'])) : '-') ?></span>
                                    </div>
                                    <?php if (! empty($message['subject'])): ?>
                                        <p class="mt-2 text-sm font-medium text-slate-700 line-clamp-2"><?= esc($message['subject']) ?></p>
                                    <?php endif; ?>
                                    <?php if (! empty($message['message'])): ?>
                                        <?php $preview = strip_tags($message['message']); $preview = function_exists('mb_strimwidth') ? mb_strimwidth($preview, 0, 120, '...', 'UTF-8') : substr($preview, 0, 120) . '...'; ?>
                                        <p class="text-sm text-slate-500 line-clamp-2"><?= esc($preview) ?></p>
                                    <?php endif; ?>
                                    <?php if (($message['is_read'] ?? 0) == 0): ?>
                                        <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-brand-soft px-3 py-1 text-xs font-semibold text-brand">
                                            <i data-lucide="bell" class="h-3.5 w-3.5"></i> Belum dibaca
                                        </span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50/90 px-4 py-8 text-center text-sm text-slate-500">
                                Tidak ada pesan terbaru.
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
                <!-- Inbox Overview -->
                <article class="card-shell p-6">
                    <div class="flex flex-col gap-2">
                        <p class="section-label">Kinerja inbox</p>
                        <h2 class="section-title text-xl">Status komunikasi</h2>
                        <p class="section-subtext text-sm">Pantau progress penanganan pesan agar respon selalu prima.</p>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-brand-soft/80 px-4 py-5">
                            <p class="text-sm text-slate-500">Total pesan</p>
                            <p class="text-2xl font-semibold text-slate-900"><?= esc($totalMessages) ?></p>
                        </div>
                        <div class="rounded-2xl bg-amber-soft/80 px-4 py-5">
                            <p class="text-sm text-slate-500">Belum dibaca</p>
                            <p class="text-2xl font-semibold text-slate-900"><?= esc($unreadMessages) ?></p>
                        </div>
                    </div>
                    <div class="mt-6 rounded-2xl border border-slate-100 p-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-800">Tingkat respon</span>
                            <?php $responseRate = $totalMessages ? round(($handledMessages / $totalMessages) * 100) : 100; ?>
                            <span class="font-semibold text-slate-900"><?= $responseRate ?>%</span>
                        </div>
                        <div class="mt-3 h-2.5 rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-emerald-500" style="width: <?= $responseRate ?>%"></div>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col gap-3">
                        <button class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-brand hover:text-brand">
                            <i data-lucide="mail-open" class="h-4 w-4"></i> Susun balasan template
                        </button>
                        <button class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                            <i data-lucide="sparkles" class="h-4 w-4"></i> Otomatiskan follow-up
                        </button>
                    </div>
                </article>
            </aside>
        </section>
    </div>
</div>
<script>
    function dashboardPage() {
        return {
            loading: true,
            init() {
                setTimeout(() => {
                    this.loading = false;
                    if (window.lucide) {
                        window.lucide.createIcons();
                    }
                }, 600);
            }
        };
    }
</script>
<?= $this->endSection() ?>
