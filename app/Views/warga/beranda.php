<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-12 md:space-y-16 pb-12">

    <!-- ======================================================== -->
    <!-- HERO SECTION: PUSAT PANDUAN & LAYANAN WARGA -->
    <!-- ======================================================== -->
    <section class="w-full relative overflow-hidden min-h-[100svh] flex flex-col justify-center items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="<?= base_url('img/gapuradesa.jpg') ?>" alt="Gapura Desa" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-slate-900/75 backdrop-blur-[2px]"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center space-y-8 mt-16 md:mt-0">
            <!-- Main Heading & Subtitle -->
            <div class="space-y-4">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight drop-shadow-sm">
                    Urus administrasi desa jadi <br class="hidden sm:inline">
                    <span class="text-desentra-teal drop-shadow-md">Mudah dan Cepat.</span>
                </h1>

                <p class="text-sm sm:text-base md:text-lg lg:text-xl text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-sm">
                    Ketahui persyaratan surat sebelum ke kantor desa, lengkapi berkas mandiri dari rumah, dan pantau tindak lanjut pengaduan tanpa calo dan bebas biaya.
                </p>
            </div>

            <!-- Search Bar Form -->
            <div class="">
                <form action="<?= base_url('layanan') ?>" method="get" class="relative flex items-center bg-white rounded-2xl md:rounded-full p-2 pl-4 sm:pl-6 focus-within:ring-4 focus-within:ring-desentra-teal/40 transition-all">
                    <svg class="w-5 h-5 text-desentra-teal shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="main-search-input" name="q" placeholder="Cari syarat surat (SKTM, KTP, Akta Lahir)..." 
                           class="w-full text-xs sm:text-sm font-medium text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none">
                    <button type="submit" class="px-5 sm:px-6 py-2.5 rounded-xl md:rounded-full bg-desentra-teal hover:bg-[#00706d] text-white text-xs sm:text-sm font-bold shadow-md active:scale-95 transition-all shrink-0">
                        Cari Panduan
                    </button>
                </form>

                <!-- Quick Query Suggestions -->
                <div class="flex items-center justify-center gap-1.5 sm:gap-2 pt-3 pb-1 text-[11px] sm:text-xs text-white flex-wrap">
                    <span class="font-medium text-white/70">Paling dicari:</span>
                    <button type="button" onclick="setSearchQuery('SKTM')" class="px-2.5 py-1 rounded-lg bg-white/20 hover:bg-white hover:text-desentra-teal transition-colors font-medium border border-white/10">SKTM</button>
                    <button type="button" onclick="setSearchQuery('Pengantar KTP')" class="px-2.5 py-1 rounded-lg bg-white/20 hover:bg-white hover:text-desentra-teal transition-colors font-medium border border-white/10">KTP & KK</button>
                    <button type="button" onclick="setSearchQuery('Akta Kelahiran')" class="px-2.5 py-1 rounded-lg bg-white/20 hover:bg-white hover:text-desentra-teal transition-colors font-medium border border-white/10">Akta Lahir</button>
                    <button type="button" onclick="setSearchQuery('Keterangan Usaha')" class="px-2.5 py-1 rounded-lg bg-white/20 hover:bg-white hover:text-desentra-teal transition-colors font-medium border border-white/10">Surat Usaha</button>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- SECTION 2: PANDUAN LAYANAN POPULER -->
    <!-- ======================================================== -->
    <section class="w-full bg-slate-50/50 py-12 md:py-16 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 max-w-5xl mx-auto">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-desentra-teal uppercase tracking-wider">Katalog Pelayanan</span>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Layanan Populer Desa
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-xl">
                        Akses cepat layanan yang paling sering dibutuhkan warga beserta panduan lengkapnya.
                    </p>
                </div>
                <a href="<?= base_url('layanan') ?>" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-desentra-teal hover:underline self-start sm:self-end">
                    <span>Lihat Seluruh Katalog</span>
                    <span>→</span>
                </a>
            </div>

            <!-- 4 Quick Access / Pillar Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto">
                
                <!-- Card 1: Katalog Layanan -->
                <a href="<?= base_url('layanan') ?>" class="bg-desentra-teal hover:bg-[#00706d] border border-transparent rounded-2xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between transform hover:-translate-y-1">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm text-white">Panduan Surat Resmi</h3>
                            <p class="text-xs text-teal-50 mt-1 leading-relaxed">Cek syarat berkas dan alur lengkap sebelum datang ke kantor desa.</p>
                        </div>
                    </div>
                    <div class="pt-3 mt-2 border-t border-white/20 flex items-center justify-between text-xs font-bold text-white">
                        <span>Buka Katalog</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                <!-- Card 2: Loket Pelayanan & Bebas Pungli -->
                <div class="bg-emerald-600 border border-transparent rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm text-white">Loket Desa Rp 0</h3>
                            <p class="text-xs text-emerald-50 mt-1 leading-relaxed">Senin – Jumat (08.00–15.00 WIB). Seluruh surat resmi tanpa biaya.</p>
                        </div>
                    </div>
                    <div class="pt-3 mt-2 border-t border-white/20 flex items-center justify-between text-xs">
                        <span class="font-bold text-emerald-900 bg-emerald-50 px-2 py-0.5 rounded-md">Bebas Pungli</span>
                        <span class="text-emerald-100 font-medium">±15 Menit</span>
                    </div>
                </div>

                <!-- Card 3: Kabar & Pengumuman -->
                <a href="<?= base_url('info-desa') ?>" class="bg-amber-500 hover:bg-amber-600 border border-transparent rounded-2xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between transform hover:-translate-y-1">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm text-white">Kabar & Agenda Desa</h3>
                            <p class="text-xs text-amber-50 mt-1 leading-relaxed">Pengumuman bansos, posyandu, dan informasi resmi pemerintah desa.</p>
                        </div>
                    </div>
                    <div class="pt-3 mt-2 border-t border-white/20 flex items-center justify-between text-xs font-bold text-white">
                        <span>Lihat Informasi</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                <!-- Card 4: Pengaduan Warga -->
                <a href="<?= base_url('pengaduan') ?>" class="bg-desentra-orange hover:bg-[#d47805] border border-transparent rounded-2xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between transform hover:-translate-y-1">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 10.5C4.5 6.358 7.858 3 12 3s7.5 3.358 7.5 7.5v4.5a3 3 0 01-3 3H15M4.5 10.5v4.5a3 3 0 003 3H9"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm text-white">Pengaduan Warga</h3>
                            <p class="text-xs text-orange-50 mt-1 leading-relaxed">Laporkan kendala fasilitas dan pantau tindak lanjut secara transparan.</p>
                        </div>
                    </div>
                    <div class="pt-3 mt-2 border-t border-white/20 flex items-center justify-between text-xs font-bold text-white">
                        <span>Lapor Sekarang</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

            </div>
        </div>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- SECTION 3: KABAR & INFORMASI DESA -->
    <!-- ======================================================== -->
    <?php if (!empty($latestInfos)): ?>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div class="space-y-1">
                <span class="text-xs font-bold text-desentra-orange uppercase tracking-wider">Informasi Publik</span>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Kabar & Pengumuman <?= esc($villageName) ?>
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xl">
                    Informasi resmi seputar agenda kegiatan, bantuan sosial, dan perkembangan desa.
                </p>
            </div>

            <a href="<?= base_url('info-desa') ?>" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-desentra-teal hover:underline self-start sm:self-end">
                <span>Lihat Semua Berita</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <?php foreach ($latestInfos as $info): ?>
            <a href="<?= base_url('info-desa/detail/' . $info['slug']) ?>" class="group bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="aspect-[16/9] w-full bg-slate-100 overflow-hidden relative">
                        <?php if (!empty($info['banner_image'])): ?>
                        <img src="<?= base_url($info['banner_image']) ?>" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                        <div class="w-full h-full bg-teal-50/60 flex items-center justify-center text-desentra-teal">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <?php endif; ?>
                        <span class="absolute top-3 left-3 text-[10px] font-bold text-slate-800 bg-white/95 px-2.5 py-0.5 rounded-md uppercase tracking-wider shadow-2xs">
                            <?= esc($info['category']) ?>
                        </span>
                    </div>

                    <div class="p-5 space-y-2">
                        <span class="text-[11px] text-slate-400 font-medium block">
                            <?= date('d M Y', strtotime($info['published_at'])) ?>
                        </span>
                        <h3 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-desentra-teal transition-colors leading-snug line-clamp-2">
                            <?= esc($info['title']) ?>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            <?= esc($info['content']) ?>
                        </p>
                    </div>
                </div>

                <div class="px-5 pb-4 pt-2 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-desentra-teal">
                    <span>Baca Selengkapnya</span>
                    <span>→</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

    </section>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- SECTION 4: KANAL PENGADUAN & TANYA JAWAB (DUAL CARDS) -->
    <!-- ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            
            <!-- Card Pengaduan -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 sm:p-8 text-white flex flex-col justify-between shadow-md">
                <div class="space-y-3">
                    <span class="inline-block text-[11px] font-bold text-desentra-orange bg-white/10 px-3 py-1 rounded-full uppercase tracking-wider">
                        Aspirasi & Lapor Kendala
                    </span>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">
                        Ada Masalah Fasilitas atau Layanan Desa?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                        Laporkan jalan rusak, lampu penerangan padam, atau kendala birokrasi. Anda akan menerima <strong>kode tiket unik</strong> untuk memantau proses tindak lanjut perangkat desa secara langsung.
                    </p>
                </div>

                <div class="pt-6 flex flex-wrap items-center gap-3">
                    <a href="<?= base_url('pengaduan') ?>" 
                       class="px-5 py-2.5 rounded-xl bg-desentra-orange hover:bg-[#d97d07] text-white font-bold text-xs sm:text-sm shadow-xs transition-all">
                        Kirim Pengaduan Baru
                    </a>
                    <a href="<?= base_url('pengaduan/status') ?>" 
                       class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs sm:text-sm transition-all">
                        Lacak Kode Tiket
                    </a>
                </div>
            </div>

            <!-- Card Tanya Jawab Layanan -->
            <div class="bg-gradient-to-br from-teal-900 to-teal-800 rounded-3xl p-6 sm:p-8 text-white flex flex-col justify-between shadow-md">
                <div class="space-y-3">
                    <span class="inline-block text-[11px] font-bold text-teal-200 bg-white/10 px-3 py-1 rounded-full uppercase tracking-wider">
                        Pusat Bantuan Warga
                    </span>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">
                        Butuh Panduan Surat Cepat?
                    </h3>
                    <p class="text-xs sm:text-sm text-teal-100/90 leading-relaxed font-normal">
                        Tanyakan syarat berkas, prosedur pengurusan, atau jam operasional loket melalui layanan tanya jawab mandiri. Informasi bersumber langsung dari SOP resmi desa.
                    </p>
                </div>

                <div class="pt-6 flex items-center gap-3">
                    <a href="<?= base_url('tanya') ?>" 
                       class="px-6 py-2.5 rounded-xl bg-white hover:bg-teal-50 text-desentra-teal font-extrabold text-xs sm:text-sm shadow-xs transition-all">
                        Tanya Jawab Layanan Sekarang →
                    </a>
                </div>
            </div>

        </div>
    </section>

</div>

<?= $this->section('scripts') ?>
<script>
    // Search prefill helper for quick chips
    function setSearchQuery(query) {
        const input = document.getElementById('main-search-input');
        if (input) {
            input.value = query;
            input.focus();
        }
    }
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
