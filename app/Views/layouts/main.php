<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= esc($title ?? 'Desentra - Panduan Layanan Desa') ?></title>
    
    <!-- PWA Settings -->
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="theme-color" content="#008683">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('img/icon.svg') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('img/icon.svg') ?>">

    <!-- Styles -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-full flex flex-col font-sans text-desentra-dark antialiased bg-[#F8FAFC]">

    <!-- Offline Notification Banner -->
    <div id="offline-banner" class="hidden bg-desentra-orange text-white text-xs font-semibold py-2 px-4 text-center sticky top-0 z-50 shadow-md">
        <div class="flex items-center justify-center space-x-2">
            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m-3.536-3.536a4.978 4.978 0 010-7.072M7.05 16.95a9 9 0 010-12.728m3.536 3.536a4.978 4.978 0 010 7.072M12 12h.01"></path>
            </svg>
            <span>Anda sedang offline. Membuka panduan dari cache tersimpan.</span>
        </div>
    </div>

    <!-- Main Mobile Frame Container -->
    <div class="w-full max-w-md mx-auto min-h-screen flex flex-col bg-white shadow-xl relative pb-safe-bottom">
        
        <!-- App Top Header (BSI Inspired: Clean Teal & Warm Orange Sparkle) -->
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-desentra-teal/10 px-4 py-3 flex items-center justify-between">
            <a href="<?= base_url('/') ?>" class="flex items-center space-x-2.5 group">
                <img src="<?= base_url('img/icon.svg') ?>" alt="Desentra Logo" class="w-8 h-8 rounded-lg shadow-2xs group-hover:scale-105 transition-transform">
                <div>
                    <div class="flex items-center gap-1">
                        <span class="font-extrabold text-lg tracking-tight text-desentra-teal">Desentra</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange inline-block" title="Sentra Layanan"></span>
                    </div>
                    <span class="block text-[10px] text-slate-400 font-semibold leading-none"><?= esc(env('DESENTRA_VILLAGE_NAME', 'Desa Sukamaju')) ?></span>
                </div>
            </a>

            <div class="flex items-center space-x-1.5">
                <a href="<?= base_url('pengaduan/status') ?>" class="p-2 text-slate-500 hover:text-desentra-orange hover:bg-orange-50/70 rounded-full transition-all" title="Lacak Tiket Pengaduan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </a>
                <a href="<?= base_url('layanan') ?>" class="p-2 text-slate-500 hover:text-desentra-teal hover:bg-teal-50/70 rounded-full transition-all" title="Cari Panduan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </a>
            </div>
        </header>

        <!-- Main Content Slot -->
        <main class="flex-1 overflow-x-hidden">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Bottom Navigation Bar (BSI Style: Teal Active State & Orange Dot Indicator) -->
        <nav class="fixed bottom-0 left-0 right-0 z-40">
            <div class="max-w-md mx-auto glass-nav px-2 py-1.5 flex justify-around items-center shadow-lg border-t border-slate-200/80">
                
                <!-- 1. Beranda -->
                <a href="<?= base_url('/') ?>" class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-200 <?= ($activeNav ?? '') === 'beranda' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-6 h-6 <?= ($activeNav ?? '') === 'beranda' ? 'scale-110 text-desentra-teal stroke-[2.4]' : '' ?> transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="text-[11px] mt-0.5">Beranda</span>
                    <?php if (($activeNav ?? '') === 'beranda'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 2. Info Desa -->
                <a href="<?= base_url('info-desa') ?>" class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-200 <?= ($activeNav ?? '') === 'info_desa' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-6 h-6 <?= ($activeNav ?? '') === 'info_desa' ? 'scale-110 text-desentra-teal stroke-[2.4]' : '' ?> transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span class="text-[11px] mt-0.5">Info Desa</span>
                    <?php if (($activeNav ?? '') === 'info_desa'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 3. Tanya (AI) - Center Action Button Khas BYOND (Teal Gradient + Star Sparkle) -->
                <a href="<?= base_url('tanya') ?>" class="flex flex-col items-center py-1 px-3 rounded-xl transition-all duration-200 relative -top-3.5 group">
                    <div class="w-13 h-13 px-3 py-2.5 rounded-full bg-gradient-to-tr from-desentra-teal via-[#009E94] to-desentra-turquoise text-white flex flex-col items-center justify-center shadow-lg shadow-desentra-teal/30 group-hover:scale-105 active:scale-95 transition-transform border-2 border-white relative">
                        <span class="font-extrabold text-[13px] tracking-tight leading-none">AI</span>
                        <!-- Tiny BSI Gold Sparkle Accent on Button -->
                        <span class="absolute top-1 right-1.5 text-[9px] text-desentra-gold leading-none">✦</span>
                    </div>
                    <span class="text-[11px] font-bold text-desentra-teal mt-0.5">Tanya</span>
                    <?php if (($activeNav ?? '') === 'tanya'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 4. Pengaduan -->
                <a href="<?= base_url('pengaduan') ?>" class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-200 <?= ($activeNav ?? '') === 'pengaduan' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-6 h-6 <?= ($activeNav ?? '') === 'pengaduan' ? 'scale-110 text-desentra-teal stroke-[2.4]' : '' ?> transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 10.5C4.5 6.358 7.858 3 12 3s7.5 3.358 7.5 7.5v4.5a3 3 0 01-3 3H15M4.5 10.5v4.5a3 3 0 003 3H9"></path>
                    </svg>
                    <span class="text-[11px] mt-0.5">Pengaduan</span>
                    <?php if (($activeNav ?? '') === 'pengaduan'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

                <!-- 5. Layanan -->
                <a href="<?= base_url('layanan') ?>" class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-200 <?= ($activeNav ?? '') === 'layanan' ? 'text-desentra-teal font-extrabold' : 'text-slate-400 hover:text-slate-600' ?>">
                    <svg class="w-6 h-6 <?= ($activeNav ?? '') === 'layanan' ? 'scale-110 text-desentra-teal stroke-[2.4]' : '' ?> transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="text-[11px] mt-0.5">Layanan</span>
                    <?php if (($activeNav ?? '') === 'layanan'): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-desentra-orange mt-0.5"></span>
                    <?php endif; ?>
                </a>

            </div>
        </nav>

    </div>

    <!-- PWA & Online/Offline Scripts -->
    <script>
        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('PWA ServiceWorker registered', reg.scope))
                    .catch(err => console.log('ServiceWorker registration failed', err));
            });
        }

        // Online/Offline detection
        function updateNetworkStatus() {
            const banner = document.getElementById('offline-banner');
            if (!navigator.onLine) {
                banner.classList.remove('hidden');
            } else {
                banner.classList.add('hidden');
            }
        }
        window.addEventListener('online', updateNetworkStatus);
        window.addEventListener('offline', updateNetworkStatus);
        updateNetworkStatus();
    </script>

    <!-- Include Global Bottom Sheet Confirmation -->
    <?= $this->include('partials/bottom_sheet_confirm') ?>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
