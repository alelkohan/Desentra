<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-5 py-5 space-y-6 overflow-hidden">

    <!-- Header Sesuai Wireframe: Judul Info Desa + Ikon Megafon Kanan Atas -->
    <div class="flex items-center justify-between">
        <div class="space-y-0.5">
            <h1 class="text-2xl font-black tracking-tight text-slate-900 font-sans">
                Info Desa
            </h1>
            <p class="text-xs text-slate-500 font-medium">
                Kabar resmi, agenda kegiatan & jadwal layanan
            </p>
        </div>

        <div class="w-10 h-10 rounded-full bg-desentra-orange/10 flex items-center justify-center text-desentra-orange shadow-2xs">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
            </svg>
        </div>
    </div>

    <!-- 3-CARD COVER-FLOW CAROUSEL SECTION -->
    <section class="space-y-4">
        <?php if (!empty($infos)): ?>
        <!-- Cover-flow Stage (Center Active + Left Card Behind + Right Card Behind) -->
        <div id="coverflow-stage" class="relative w-full h-[470px] select-none touch-pan-y cursor-grab active:cursor-grabbing overflow-visible flex items-center justify-center">
            
            <?php foreach ($infos as $idx => $info): ?>
            <?php
            // Robust image URL generator
            $cardImg = '';
            if (!empty($info['banner_image'])) {
                $cardImg = filter_var($info['banner_image'], FILTER_VALIDATE_URL) 
                    ? $info['banner_image'] 
                    : base_url(ltrim($info['banner_image'], '/'));
            } else {
                $cardImg = base_url('img/poster-default.png');
            }
            $fallbackPoster = base_url('img/poster-default.png');
            ?>
            <!-- Card Item (Position Absolute at left: 50%, managed by 3-card cover-flow transform) -->
            <div id="coverflow-card-<?= $idx ?>"
                 class="coverflow-card absolute top-0 left-1/2 w-[82%] max-w-[325px] h-[465px] bg-white border border-slate-200/90 rounded-3xl p-5 shadow-md flex flex-col overflow-hidden will-change-transform"
                 data-index="<?= $idx ?>">
                
                <!-- 1. FLEXIBLE CONTENT AREA (Area Konten Fleksibel) -->
                <div class="flex-1 min-h-0 flex flex-col space-y-2 pointer-events-none">
                    
                    <!-- Info Header (Kategori, Judul Terkunci 2 Baris, Tanggal) -->
                    <div class="space-y-1.5 shrink-0">
                        <div class="flex items-center justify-between">
                            <span class="inline-block text-[10px] font-extrabold text-desentra-orange bg-orange-50 border border-orange-100 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                <?= esc($info['category']) ?>
                            </span>
                            <span class="text-[10px] font-mono font-bold text-slate-400">
                                #<?= $idx + 1 ?>
                            </span>
                        </div>

                        <!-- Ketinggian judul konsisten 2 baris agar layout seragam di semua kartu -->
                        <h2 class="font-extrabold text-sm sm:text-base text-slate-900 leading-snug line-clamp-2 h-[2.75rem] flex items-center">
                            <?= esc($info['title']) ?>
                        </h2>

                        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-semibold">
                            <span class="text-xs">🗓</span>
                            <span>
                                <?= !empty($info['valid_until']) ? date('d F Y', strtotime($info['valid_until'])) : date('d F Y', strtotime($info['published_at'])) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Poster Gambar Besar Fleksibel dengan Background Fallback Elegan -->
                    <div class="flex-1 min-h-0 w-full rounded-2xl overflow-hidden border border-slate-100 bg-slate-100 relative my-1">
                        <!-- Fallback Placeholder jika gambar gagal dimuat (tanpa teks alt besar) -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#008683] to-[#3C7087] flex flex-col items-center justify-center p-4 text-center text-white select-none">
                            <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-1.5 shadow-inner">
                                <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-200">Kabar Desa</span>
                            <span class="text-xs font-bold line-clamp-2 mt-0.5 text-white/90"><?= esc($info['title']) ?></span>
                        </div>

                        <!-- Gambar Poster Asli -->
                        <img src="<?= esc($cardImg) ?>" 
                             alt="" 
                             class="w-full h-full object-cover absolute inset-0 z-10 transition-opacity duration-300"
                             loading="eager"
                             onerror="this.onerror=null; this.src='<?= esc($fallbackPoster) ?>';">
                    </div>

                </div>

                <!-- 2. TOMBOL SELENGKAPNYA DI BAGIAN PALING BAWAH CARD (BSI Style Teal Gradient) -->
                <div class="mt-auto pt-3 shrink-0 w-full relative z-20">
                    <a href="<?= base_url('info-desa/detail/' . $info['slug']) ?>" 
                       class="card-action-btn block w-full py-2.5 rounded-full bg-gradient-to-r from-desentra-teal to-[#009E94] text-white text-xs font-extrabold text-center hover:opacity-95 active:scale-[0.98] transition-all shadow-sm shadow-desentra-teal/25 border border-white/20">
                        Selengkapnya
                    </a>
                </div>

            </div>
            <?php endforeach; ?>

        </div>

        <!-- Controls: Nav Buttons & Dots Pagination -->
        <div class="flex items-center justify-between px-1">
            
            <!-- Tombol Navigasi Kiri / Kanan -->
            <div class="flex items-center gap-1.5">
                <button type="button" id="prev-btn" onclick="prevCard()" class="w-8 h-8 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-700 hover:text-desentra-teal hover:border-desentra-teal shadow-2xs active:scale-95 transition-all" title="Card Sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button type="button" id="next-btn" onclick="nextCard()" class="w-8 h-8 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-700 hover:text-desentra-teal hover:border-desentra-teal shadow-2xs active:scale-95 transition-all" title="Card Berikutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Pagination Dots (o • o o) Maksimal 4 Titik Sesuai Jumlah Data -->
            <div class="flex items-center gap-1.5" id="dots-container">
                <?php foreach ($carouselInfos ?? $infos as $idx => $info): ?>
                <span class="carousel-dot h-2 rounded-full transition-all duration-300 <?= $idx === 0 ? 'w-6 bg-desentra-teal' : 'w-2 bg-slate-300 hover:bg-slate-400 cursor-pointer' ?>"
                      onclick="goToCard(<?= $idx ?>)"></span>
                <?php endforeach; ?>
            </div>

            <span class="text-[11px] font-semibold text-slate-400 flex items-center gap-1">
                <span>Swipe</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
            </span>
        </div>
        <?php else: ?>
        <div class="w-full py-12 text-center space-y-2 bg-white rounded-3xl border border-dashed border-slate-200 p-6 shadow-xs">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-2">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
            <p class="text-xs font-bold text-slate-700">Belum ada informasi terbaru untuk kategori ini</p>
            <p class="text-[11px] text-slate-400">Silakan pilih kategori lain atau periksa arsip informasi di bawah.</p>
        </div>
        <?php endif; ?>
    </section>

    <!-- Category Tabs Filter (BSI Style: Teal Active State) -->
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pt-2" id="category-tabs-nav">
        <?php foreach ($categories as $catKey => $catLabel): ?>
        <button type="button"
                data-category="<?= esc($catKey) ?>"
                onclick="filterCategory('<?= esc($catKey) ?>')"
                class="category-tab-btn whitespace-nowrap px-4 py-1.5 rounded-full text-xs font-bold transition-all <?= ($currentCategory ?? 'all') === $catKey ? 'bg-gradient-to-r from-desentra-teal to-desentra-turquoise text-white shadow-sm shadow-desentra-teal/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-desentra-teal/40 hover:text-desentra-teal' ?>">
            <?= esc($catLabel) ?>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- Feed / List Semua Informasi Desa -->
    <section class="space-y-3 pb-2">
        <h3 class="font-extrabold text-sm text-slate-900">Semua Informasi & Arsip</h3>

        <div class="space-y-3" id="archive-list-container">
            <?php foreach ($allInfos ?? $infos as $info): ?>
            <?php
            $feedImg = !empty($info['banner_image']) 
                ? (filter_var($info['banner_image'], FILTER_VALIDATE_URL) ? $info['banner_image'] : base_url(ltrim($info['banner_image'], '/')))
                : base_url('img/poster-default.png');
            $shouldHide = (($currentCategory ?? 'all') !== 'all' && ($currentCategory ?? 'all') !== $info['category']);
            ?>
            <article class="info-archive-card bg-white border border-slate-200/90 rounded-3xl p-4 shadow-xs space-y-3 transition-opacity duration-200 <?= $shouldHide ? 'hidden' : '' ?>"
                     data-category="<?= esc($info['category']) ?>">
                <div class="flex items-center gap-3">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 border border-slate-100 bg-slate-100 relative">
                        <img src="<?= esc($feedImg) ?>" 
                             alt="" 
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='<?= base_url('img/poster-default.png') ?>';">
                    </div>

                    <div class="space-y-1 flex-1 overflow-hidden">
                        <div class="flex items-center justify-between text-[10px] text-slate-400">
                            <span class="font-bold text-desentra-orange uppercase tracking-wider"><?= esc($info['category']) ?></span>
                            <span><?= date('d M Y', strtotime($info['published_at'])) ?></span>
                        </div>
                        <h4 class="font-bold text-xs text-slate-900 line-clamp-2 leading-snug">
                            <a href="<?= base_url('info-desa/detail/' . $info['slug']) ?>" class="hover:text-desentra-teal transition-colors">
                                <?= esc($info['title']) ?>
                            </a>
                        </h4>
                        <p class="text-[11px] text-slate-500 line-clamp-1 leading-relaxed">
                            <?= esc($info['content']) ?>
                        </p>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <?php if (!empty($info['valid_until'])): ?>
                    <span class="text-slate-400 text-[10px]">
                        Berlaku s/d: <strong><?= date('d M Y', strtotime($info['valid_until'])) ?></strong>
                    </span>
                    <?php else: ?>
                    <span class="text-slate-400 text-[10px]">Informasi Umum</span>
                    <?php endif; ?>

                    <a href="<?= base_url('info-desa/detail/' . $info['slug']) ?>" class="font-bold text-desentra-teal hover:underline text-xs">
                        Lihat Rincian →
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Empty state jika kategori yang difilter tidak memiliki berita -->
        <div id="archive-empty-state" class="hidden w-full py-10 text-center space-y-2 bg-white rounded-3xl border border-dashed border-slate-200 p-6 shadow-xs">
            <div class="w-10 h-10 mx-auto rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-1">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
            <p class="text-xs font-bold text-slate-700">Tidak ada informasi pada kategori ini</p>
            <p class="text-[11px] text-slate-400">Pilih kategori lain untuk melihat kabar desa lainnya.</p>
        </div>
    </section>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // NON-LOOPING 4-CARD COVER-FLOW CAROUSEL LOGIC
    let currentIndex = 0;
    const cards = document.querySelectorAll('.coverflow-card');
    const totalCards = cards.length;
    const dots = document.querySelectorAll('.carousel-dot');
    const stage = document.getElementById('coverflow-stage');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    // Smooth Bezier Curve transition (memberikan sensasi maju ke depan / mundur)
    const transitionStyle = 'transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.4s ease, filter 0.4s ease, box-shadow 0.4s ease';

    function updateCoverflow() {
        if (totalCards === 0) return;

        // 1. UPDATE BUTTONS STATE (Disabled pada Ujung Awal & Akhir)
        if (prevBtn) {
            if (currentIndex === 0) {
                prevBtn.disabled = true;
                prevBtn.classList.add('opacity-20', 'pointer-events-none');
                prevBtn.classList.remove('hover:border-desentra-teal', 'hover:text-desentra-teal', 'shadow-2xs', 'active:scale-95');
            } else {
                prevBtn.disabled = false;
                prevBtn.classList.remove('opacity-20', 'pointer-events-none');
                prevBtn.classList.add('hover:border-desentra-teal', 'hover:text-desentra-teal', 'shadow-2xs', 'active:scale-95');
            }
        }

        if (nextBtn) {
            if (currentIndex === totalCards - 1) {
                nextBtn.disabled = true;
                nextBtn.classList.add('opacity-20', 'pointer-events-none');
                nextBtn.classList.remove('hover:border-desentra-teal', 'hover:text-desentra-teal', 'shadow-2xs', 'active:scale-95');
            } else {
                nextBtn.disabled = false;
                nextBtn.classList.remove('opacity-20', 'pointer-events-none');
                nextBtn.classList.add('hover:border-desentra-teal', 'hover:text-desentra-teal', 'shadow-2xs', 'active:scale-95');
            }
        }

        // 2. POSITION EACH CARD (LINEAR COVER-FLOW, NO INFINITE LOOP)
        const isFirst = (currentIndex === 0 && totalCards > 1);
        const isLast  = (currentIndex === totalCards - 1 && totalCards > 1);

        cards.forEach((card, index) => {
            card.style.transition = transitionStyle;
            const btn = card.querySelector('.card-action-btn');

            // Hitung selisih linear murni (tanpa modulo)
            const diff = index - currentIndex;

            if (diff === 0) {
                // CARD AKTIF (Depan / z-index 30)
                if (isFirst) {
                    // Ketika di card pertama: menjadi slide paling kiri (tidak ada card di kiri)
                    card.style.transform = 'translate(calc(-50% - 24px), 0) scale(1)';
                } else if (isLast) {
                    // Ketika di card terakhir: menjadi slide paling kanan (tidak ada card di kanan)
                    card.style.transform = 'translate(calc(-50% + 24px), 0) scale(1)';
                } else {
                    // Card tengah normal
                    card.style.transform = 'translate(-50%, 0) scale(1)';
                }

                card.style.zIndex = '30';
                card.style.opacity = '1';
                card.style.filter = 'brightness(1)';
                card.style.pointerEvents = 'auto';
                card.classList.add('shadow-xl', 'ring-1', 'ring-slate-900/10');
                card.classList.remove('shadow-sm', 'cursor-pointer');
                if (btn) btn.style.pointerEvents = 'auto';

            } else if (diff === -1) {
                // CARD SEBELUMNYA (Di belakang sebelah kiri)
                if (isLast) {
                    card.style.transform = 'translate(calc(-50% - 95px), 0) scale(0.88)';
                } else {
                    card.style.transform = 'translate(calc(-50% - 110px), 0) scale(0.86)';
                }
                card.style.zIndex = '15';
                card.style.opacity = '0.78';
                card.style.filter = 'brightness(0.92)';
                card.style.pointerEvents = 'auto';
                card.classList.remove('shadow-xl', 'ring-1');
                card.classList.add('shadow-sm', 'cursor-pointer');
                if (btn) btn.style.pointerEvents = 'none';

            } else if (diff === 1) {
                // CARD BERIKUTNYA (Di belakang sebelah kanan)
                if (isFirst) {
                    card.style.transform = 'translate(calc(-50% + 95px), 0) scale(0.88)';
                } else {
                    card.style.transform = 'translate(calc(-50% + 110px), 0) scale(0.86)';
                }
                card.style.zIndex = '15';
                card.style.opacity = '0.78';
                card.style.filter = 'brightness(0.92)';
                card.style.pointerEvents = 'auto';
                card.classList.remove('shadow-xl', 'ring-1');
                card.classList.add('shadow-sm', 'cursor-pointer');
                if (btn) btn.style.pointerEvents = 'none';

            } else {
                // CARD LAINNYA (Tersembunyi di luar layar)
                const dir = diff > 0 ? 1 : -1;
                card.style.transform = `translate(calc(-50% + ${dir * 220}px), 0) scale(0.7)`;
                card.style.zIndex = '5';
                card.style.opacity = '0';
                card.style.pointerEvents = 'none';
                card.classList.remove('shadow-xl', 'ring-1');
                if (btn) btn.style.pointerEvents = 'none';
            }
        });

        // 3. UPDATE DOTS PAGINATION
        dots.forEach((dot, idx) => {
            if (idx === currentIndex) {
                dot.className = 'carousel-dot h-2 w-6 rounded-full bg-desentra-teal transition-all duration-300';
            } else {
                dot.className = 'carousel-dot h-2 w-2 rounded-full bg-slate-300 hover:bg-slate-400 transition-all duration-300 cursor-pointer';
            }
        });
    }

    // Navigasi Tanpa Infinite Loop (Linear Bound)
    function nextCard() {
        if (currentIndex < totalCards - 1) {
            currentIndex++;
            updateCoverflow();
        }
    }

    function prevCard() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCoverflow();
        }
    }

    function goToCard(idx) {
        if (idx >= 0 && idx < totalCards) {
            currentIndex = idx;
            updateCoverflow();
        }
    }

    // Klik pada card kiri/kanan memajukan kartu tersebut ke tengah
    cards.forEach((card) => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('.card-action-btn')) return;

            const idx = parseInt(card.dataset.index);
            if (idx !== currentIndex) {
                goToCard(idx);
            }
        });
    });

    // SWIPE & DRAG TOUCH/MOUSE HANDLING (Dengan Batas Linear)
    let startX = 0;
    let isDragging = false;

    if (stage) {
        // Touch events untuk Mobile HP
        stage.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        }, { passive: true });

        stage.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            const endX = e.changedTouches[0].clientX;
            const deltaX = endX - startX;

            // Threshold swipe 35px
            if (deltaX < -35) {
                nextCard(); // Geser ke kiri -> card berikutnya
            } else if (deltaX > 35) {
                prevCard(); // Geser ke kanan -> card sebelumnya
            }
        }, { passive: true });

        // Mouse events untuk Browser Desktop
        stage.addEventListener('mousedown', (e) => {
            startX = e.clientX;
            isDragging = true;
        });
    }

    window.addEventListener('mouseup', (e) => {
        if (!isDragging) return;
        isDragging = false;
        const deltaX = e.clientX - startX;

        if (deltaX < -35) {
            nextCard();
        } else if (deltaX > 35) {
            prevCard();
        }
    });

    // FILTER KATEGORI KHUSUS UNTUK FEED / ARSIP DI BAWAH CAROUSEL (Carousel di atas tidak terpengaruh)
    function filterCategory(categoryKey) {
        // 1. Update style tombol tab
        const tabButtons = document.querySelectorAll('.category-tab-btn');
        tabButtons.forEach(btn => {
            if (btn.dataset.category === categoryKey) {
                btn.className = 'category-tab-btn whitespace-nowrap px-4 py-1.5 rounded-full text-xs font-bold transition-all bg-gradient-to-r from-desentra-teal to-desentra-turquoise text-white shadow-sm shadow-desentra-teal/25';
            } else {
                btn.className = 'category-tab-btn whitespace-nowrap px-4 py-1.5 rounded-full text-xs font-bold transition-all bg-white text-slate-600 border border-slate-200 hover:border-desentra-teal/40 hover:text-desentra-teal';
            }
        });

        // 2. Filter card-card di arsip
        const archiveCards = document.querySelectorAll('.info-archive-card');
        const emptyState = document.getElementById('archive-empty-state');
        let visibleCount = 0;

        archiveCards.forEach(card => {
            const cardCat = card.dataset.category;
            if (categoryKey === 'all' || cardCat === categoryKey) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // 3. Tampilkan empty state jika tidak ada card yang cocok
        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // 4. Update browser URL tanpa reload (Carousel tetap di posisinya)
        const url = new URL(window.location.href);
        if (categoryKey === 'all') {
            url.searchParams.delete('kategori');
        } else {
            url.searchParams.set('kategori', categoryKey);
        }
        window.history.replaceState({}, '', url);
    }

    // Inisialisasi awal saat halaman dibuka
    document.addEventListener('DOMContentLoaded', () => {
        updateCoverflow();
    });
</script>
<?= $this->endSection() ?>
