<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10 space-y-6 pb-28 md:pb-16">

    <!-- Header: Modern BSI Aesthetic with Accent Sparkle -->
    <div class="space-y-1">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900 flex items-center gap-1.5 font-sans">
                <span>Katalog Layanan</span>
                <span class="w-2 h-2 rounded-full bg-desentra-orange" title="Layanan Resmi Desa"></span>
            </h1>
        </div>
        <p class="text-xs md:text-sm text-slate-500 font-medium leading-relaxed">
            Pilih layanan untuk melihat persyaratan berkas dan alur pengurusan resmi kantor desa.
        </p>
    </div>

    <!-- Search Form (Pristine Rounded-2xl with Focus Glow) -->
    <div class="max-w-2xl">
        <form action="<?= base_url('layanan') ?>" method="get" class="relative">
            <?php if (!empty($currentCategory) && $currentCategory !== 'all'): ?>
                <input type="hidden" name="kategori" value="<?= esc($currentCategory) ?>">
            <?php endif; ?>
            <input type="text" name="q" value="<?= esc($searchQuery ?? '') ?>" 
                   placeholder="Cari layanan (KTP, KK, SKTM, Usaha)..." 
                   class="w-full pl-10 pr-10 py-2.5 md:py-3 bg-white border border-slate-200/90 rounded-2xl text-xs md:text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal/30 focus:border-desentra-teal shadow-[0_2px_8px_-2px_rgba(0,0,0,0.04)] transition-all">
            <svg class="w-4 h-4 md:w-5 md:h-5 text-desentra-teal absolute left-3.5 top-3 md:top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <?php if (!empty($searchQuery)): ?>
            <a href="<?= base_url('layanan' . ($currentCategory !== 'all' ? '?kategori=' . urlencode($currentCategory) : '')) ?>" class="absolute right-3.5 top-2.5 md:top-3 text-slate-400 hover:text-slate-600 p-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Category Filter Chips (Full Bleed Scrolling on Mobile, Flex Wrap on Desktop) -->
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 -mx-5 px-5 md:mx-0 md:px-0 md:flex-wrap md:overflow-visible scroll-smooth">
        <?php foreach ($categories as $catKey => $catLabel): ?>
            <?php $isActive = ($currentCategory ?? 'all') === $catKey; ?>
            <a href="<?= base_url('layanan?kategori=' . urlencode($catKey) . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" 
               class="whitespace-nowrap px-4 py-1.5 md:py-2 rounded-full text-xs font-bold transition-all duration-200 shrink-0 <?= $isActive ? 'bg-gradient-to-r from-desentra-teal to-[#009E94] text-white shadow-md shadow-teal-900/15 scale-100 ring-2 ring-desentra-teal/20' : 'bg-white text-slate-600 border border-slate-200/90 hover:border-desentra-teal/40 hover:text-desentra-teal hover:bg-teal-50/40 shadow-2xs' ?>">
                <?= esc($catLabel) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Guides Grid: 1 Kolom di Mobile, 2-3 Kolom di Desktop -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 md:gap-5">
        <?php if (empty($guides)): ?>
        <div class="text-center py-12 bg-white rounded-3xl border border-slate-200 p-6 space-y-3 shadow-xs">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-teal-50 text-desentra-teal flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="font-extrabold text-sm text-slate-800">Panduan tidak ditemukan</h3>
            <p class="text-xs text-slate-500 max-w-xs mx-auto">
                Coba gunakan kata kunci lain atau tanyakan langsung pada asisten AI Desentra.
            </p>
            <a href="<?= base_url('tanya') ?>" class="inline-flex items-center gap-1.5 bg-gradient-to-r from-desentra-teal to-[#009E94] text-white text-xs font-bold px-4 py-2 rounded-2xl shadow-md shadow-teal-900/15 hover:opacity-95 transition-opacity">
                <span>Tanya AI Desentra</span>
                <span>✨</span>
            </a>
        </div>
        <?php else: ?>
            <?php foreach ($guides as $guide): ?>
                <?php
                // Tentukan Tema Visual & Ilustrasi Berdasarkan Kategori / Judul Layanan
                $catLower = strtolower($guide['category'] . ' ' . $guide['title']);
                
                if (str_contains($catLower, 'usaha') || str_contains($catLower, 'skdu') || str_contains($catLower, 'ekonomi') || str_contains($catLower, 'perizinan')) {
                    // Tema: Ekonomi & Usaha (Gold / Amber Palette)
                    $themeBadge = 'bg-amber-50 text-amber-800 border-amber-200/80';
                    $themeBox   = 'bg-gradient-to-br from-amber-50 via-orange-50/70 to-amber-100/50 border-amber-200/70 text-amber-700';
                    $themeDot   = 'bg-desentra-orange';
                    $illustrationType = 'business';
                } elseif (str_contains($catLower, 'sktm') || str_contains($catLower, 'sosial') || str_contains($catLower, 'bantuan') || str_contains($catLower, 'bansos')) {
                    // Tema: Sosial & Bantuan (Emerald / Heart Palette)
                    $themeBadge = 'bg-emerald-50 text-emerald-800 border-emerald-200/80';
                    $themeBox   = 'bg-gradient-to-br from-emerald-50 via-teal-50/70 to-emerald-100/50 border-emerald-200/70 text-emerald-700';
                    $themeDot   = 'bg-emerald-500';
                    $illustrationType = 'social';
                } else {
                    // Tema: Kependudukan / Dokumen Resmi (BSI Corporate Teal Palette)
                    $themeBadge = 'bg-teal-50 text-desentra-teal border-teal-200/80';
                    $themeBox   = 'bg-gradient-to-br from-teal-50 via-[#E6F4F3] to-teal-100/50 border-teal-200/70 text-desentra-teal';
                    $themeDot   = 'bg-desentra-teal';
                    $illustrationType = 'identity';
                }
                ?>

                <!-- Entire Card is Fully Clickable with Rich Interactive States -->
                <a href="<?= base_url('layanan/detail/' . $guide['slug']) ?>" 
                   class="group block bg-white border border-slate-200/90 rounded-3xl p-4 sm:p-4.5 shadow-[0_2px_10px_-2px_rgba(15,23,42,0.04)] hover:border-desentra-teal/60 hover:shadow-[0_8px_25px_-4px_rgba(0,134,131,0.14)] active:scale-[0.985] transition-all duration-200 relative overflow-hidden">
                    
                    <!-- Ambient Glow on Hover -->
                    <div class="absolute -top-10 -right-10 w-28 h-28 rounded-full bg-teal-50/40 blur-xl pointer-events-none group-hover:bg-teal-100/50 transition-colors"></div>

                    <div class="flex items-start justify-between gap-3.5 relative z-10">
                        
                        <!-- Left Content Area -->
                        <div class="space-y-1.5 flex-1 min-w-0">
                            
                            <!-- Category Badge with Dot Accent -->
                            <div class="flex items-center gap-1.5">
                                <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase tracking-wide px-2 py-0.5 rounded-full border <?= $themeBadge ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $themeDot ?>"></span>
                                    <span><?= esc($guide['category']) ?></span>
                                </span>
                            </div>

                            <!-- Title -->
                            <h2 class="font-extrabold text-[15px] sm:text-base text-slate-900 group-hover:text-desentra-teal transition-colors leading-snug line-clamp-2 pt-0.5">
                                <?= esc($guide['title']) ?>
                            </h2>

                            <!-- Summary -->
                            <p class="text-xs text-slate-500 font-normal leading-relaxed line-clamp-2">
                                <?= esc($guide['summary']) ?>
                            </p>

                            <!-- Meta Chips (Biaya & Estimasi Durasi) -->
                            <div class="flex items-center gap-2 pt-1 text-[11px] font-semibold text-slate-600">
                                <div class="inline-flex items-center gap-1 bg-slate-50/90 px-2 py-0.5 rounded-lg border border-slate-100">
                                    <span class="text-emerald-600">💰</span>
                                    <span><?= esc($guide['fee_description'] ?? 'Gratis') ?></span>
                                </div>
                                <div class="inline-flex items-center gap-1 bg-slate-50/90 px-2 py-0.5 rounded-lg border border-slate-100">
                                    <span class="text-desentra-orange">⏱</span>
                                    <span><?= esc($guide['estimated_duration'] ?? '1 Hari') ?></span>
                                </div>
                            </div>

                            <!-- Tombol 'Lihat' Berbentuk Pill Elegan Khas BSI -->
                            <div class="pt-2">
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-teal-50/80 group-hover:bg-desentra-teal text-desentra-teal group-hover:text-white border border-desentra-teal/25 group-hover:border-desentra-teal text-xs font-black transition-all duration-200 shadow-2xs">
                                    <span>Lihat</span>
                                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>

                        </div>

                        <!-- Right Illustration Box: Rich, Contextual & Modern SVG Artwork -->
                        <div class="w-20 h-20 sm:w-22 sm:h-22 rounded-2xl border flex items-center justify-center shrink-0 relative overflow-hidden group-hover:scale-105 transition-transform duration-300 shadow-2xs <?= $themeBox ?>">
                            
                            <?php if ($illustrationType === 'business'): ?>
                                <!-- Ilustrasi UMKM / Toko / Tempat Usaha -->
                                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Awning / Kanopi Toko -->
                                    <path d="M8 18L10 12H38L40 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 18C8 20.2 9.8 22 12 22C14.2 22 16 20.2 16 18C16 20.2 17.8 22 20 22C22.2 22 24 20.2 24 18C24 20.2 25.8 22 28 22C30.2 22 32 20.2 32 18C32 20.2 33.8 22 36 22C38.2 22 40 20.2 40 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <!-- Bangunan Toko -->
                                    <path d="M10 22V36C10 37.1 10.9 38 12 38H36C37.1 38 38 37.1 38 36V22" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                    <!-- Pintu Toko -->
                                    <path d="M20 38V28C20 26.9 20.9 26 22 26H26C27.1 26 28 26.9 28 28V38" stroke="currentColor" stroke-width="2.2"/>
                                    <!-- Aksen Bintang Verifikasi Emas BSI -->
                                    <circle cx="37" cy="11" r="5" fill="#F08F0E"/>
                                    <path d="M37 8.5L37.8 10.2L39.7 10.4L38.3 11.7L38.7 13.5L37 12.6L35.3 13.5L35.7 11.7L34.3 10.4L36.2 10.2L37 8.5Z" fill="white"/>
                                </svg>

                            <?php elseif ($illustrationType === 'social'): ?>
                                <!-- Ilustrasi Bantuan Sosial / Perlindungan & Hati -->
                                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Perisai Perlindungan -->
                                    <path d="M24 6L38 11V22C38 31.5 32 39.5 24 42C16 39.5 10 31.5 10 22V11L24 6Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <!-- Simbol Hati Bantuan -->
                                    <path d="M24 28.5L22.5 27.2C17.5 22.7 14.5 20 14.5 16.5C14.5 13.7 16.7 11.5 19.5 11.5C21.1 11.5 22.6 12.2 23.5 13.4C24.4 12.2 25.9 11.5 27.5 11.5C30.3 11.5 32.5 13.7 32.5 16.5C32.5 20 29.5 22.7 24.5 27.2L24 28.5Z" fill="#F08F0E"/>
                                    <!-- Uluran Tangan -->
                                    <path d="M18 33C21.5 35 26.5 35 30 33" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>

                            <?php else: ?>
                                <!-- Ilustrasi Kependudukan / Kartu Identitas & Dokumen Resmi -->
                                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Kartu ID / KTP -->
                                    <rect x="7" y="11" width="34" height="26" rx="4" stroke="currentColor" stroke-width="2.5"/>
                                    <!-- Foto Profil Kotak -->
                                    <rect x="12" y="17" width="9" height="11" rx="2" fill="currentColor" fill-opacity="0.15" stroke="currentColor" stroke-width="1.8"/>
                                    <circle cx="16.5" cy="21" r="2" fill="currentColor"/>
                                    <path d="M13.5 26C14.2 24.5 15.2 24 16.5 24C17.8 24 18.8 24.5 19.5 26" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                    <!-- Baris Data KTP -->
                                    <line x1="25" y1="18" x2="36" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="25" y1="23" x2="34" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="25" y1="28" x2="31" y2="28" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Chip Pintar Aksen Emas BSI -->
                                    <rect x="33" y="12" width="6" height="5" rx="1" fill="#F08F0E"/>
                                </svg>
                            <?php endif; ?>

                            <!-- Subtle Background Floating Dot -->
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white/40 blur-xs"></div>
                        </div>

                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>
