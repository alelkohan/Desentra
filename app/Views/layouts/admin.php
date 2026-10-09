<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= esc($title ?? 'Panel Admin Desa - Desentra') ?></title>
    
    <link rel="icon" type="image/svg+xml" href="<?= base_url('img/icon.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-full flex flex-col font-sans text-desentra-dark antialiased bg-slate-100">

    <!-- Mobile Frame Container -->
    <div class="w-full max-w-md mx-auto min-h-screen flex flex-col bg-[#F8FAFC] shadow-2xl relative pb-safe-bottom">
        
        <!-- Admin Top Header (BSI Inspired: Clean Corporate Polish) -->
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-4 py-2.5 flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center space-x-2.5 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-desentra-teal to-[#009E94] p-0.5 shadow-2xs flex items-center justify-center shrink-0">
                        <img src="<?= base_url('img/icon.svg') ?>" alt="Desentra" class="w-full h-full rounded-[10px]">
                    </div>
                    <div>
                        <div class="flex items-center gap-1">
                            <span class="font-extrabold text-base tracking-tight text-desentra-teal">Desentra</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange" title="Panel Petugas"></span>
                        </div>
                        <span class="block text-[10px] text-slate-400 font-semibold leading-none">
                            <?= esc(session('admin_name') ?? 'Petugas Desa') ?>
                        </span>
                    </div>
                </a>
            </div>

            <div class="flex items-center space-x-1.5">
                <!-- Role Badge -->
                <?php
                $role = session('admin_role') ?? 'admin';
                $roleLabels = [
                    'admin'    => 'Superadmin',
                    'editor'   => 'Editor',
                    'verifier' => 'Verifikator',
                ];
                $roleColors = [
                    'admin'    => 'bg-purple-50 text-purple-700 border-purple-200/80',
                    'editor'   => 'bg-blue-50 text-blue-700 border-blue-200/80',
                    'verifier' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
                ];
                $roleBadge = $roleColors[$role] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                $roleLabel = $roleLabels[$role] ?? ucfirst($role);
                ?>
                <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border shadow-2xs <?= $roleBadge ?>">
                    <?= esc($roleLabel) ?>
                </span>

                <!-- Link ke Portal Publik Warga -->
                <a href="<?= base_url('/') ?>" target="_blank" class="p-1.5 text-slate-400 hover:text-desentra-teal hover:bg-teal-50/70 rounded-xl transition-all border border-transparent hover:border-teal-200/60" title="Buka Portal Warga">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>

                <!-- Logout with Bottom Sheet Confirmation -->
                <a href="<?= base_url('admin/logout') ?>" 
                   data-confirm="Sesi petugas Anda akan diakhiri dan harus login kembali untuk bertugas." 
                   data-confirm-title="Keluar dari Panel Admin?" 
                   data-confirm-type="warning" 
                   data-confirm-btn="Ya, Keluar" 
                   class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all border border-transparent hover:border-rose-200/60" title="Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </a>
            </div>
        </header>

        <!-- Flash Messages Banner (Toasts) -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="mx-4 mt-3 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <span>✓</span>
                <span><?= esc(session()->getFlashdata('success')) ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">✕</button>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="mx-4 mt-3 p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <span>⚠</span>
                <span><?= esc(session()->getFlashdata('error')) ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">✕</button>
        </div>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Admin Mobile Bottom Navigation Bar (5 Core Admin Modules) -->
        <nav class="fixed bottom-0 left-0 right-0 z-40">
            <div class="max-w-md mx-auto glass-nav px-1 py-1 flex justify-around items-center shadow-lg border-t border-slate-200">
                
                <!-- 1. Dashboard -->
                <a href="<?= base_url('admin/dashboard') ?>" class="flex flex-col items-center py-1 px-2 rounded-xl transition-all <?= ($activeTab ?? '') === 'dashboard' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-5 h-5 <?= ($activeTab ?? '') === 'dashboard' ? 'scale-110 text-desentra-teal' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="text-[10px] mt-0.5">Statistik</span>
                    <?php if (($activeTab ?? '') === 'dashboard'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 2. Panduan Layanan -->
                <a href="<?= base_url('admin/layanan') ?>" class="flex flex-col items-center py-1 px-2 rounded-xl transition-all <?= ($activeTab ?? '') === 'layanan' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-5 h-5 <?= ($activeTab ?? '') === 'layanan' ? 'scale-110 text-desentra-teal' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-[10px] mt-0.5">Panduan</span>
                    <?php if (($activeTab ?? '') === 'layanan'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 3. Info Desa -->
                <a href="<?= base_url('admin/info-desa') ?>" class="flex flex-col items-center py-1 px-2 rounded-xl transition-all <?= ($activeTab ?? '') === 'info_desa' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-5 h-5 <?= ($activeTab ?? '') === 'info_desa' ? 'scale-110 text-desentra-teal' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span class="text-[10px] mt-0.5">Info Desa</span>
                    <?php if (($activeTab ?? '') === 'info_desa'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 4. Pengaduan Warga -->
                <a href="<?= base_url('admin/pengaduan') ?>" class="flex flex-col items-center py-1 px-2 rounded-xl transition-all <?= ($activeTab ?? '') === 'pengaduan' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-5 h-5 <?= ($activeTab ?? '') === 'pengaduan' ? 'scale-110 text-desentra-teal' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 10.5C4.5 6.358 7.858 3 12 3s7.5 3.358 7.5 7.5v4.5a3 3 0 01-3 3H15M4.5 10.5v4.5a3 3 0 003 3H9"></path>
                    </svg>
                    <span class="text-[10px] mt-0.5">Pengaduan</span>
                    <?php if (($activeTab ?? '') === 'pengaduan'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 5. Antrean AI (Review Fallback) -->
                <a href="<?= base_url('admin/ai-antrean') ?>" class="flex flex-col items-center py-1 px-2 rounded-xl transition-all <?= ($activeTab ?? '') === 'ai_antrean' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-5 h-5 <?= ($activeTab ?? '') === 'ai_antrean' ? 'scale-110 text-desentra-teal' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-[10px] mt-0.5">Antrean AI</span>
                    <?php if (($activeTab ?? '') === 'ai_antrean'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

            </div>
        </nav>

    </div>

    <!-- Include Global Bottom Sheet Confirmation -->
    <?= $this->include('partials/bottom_sheet_confirm') ?>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
