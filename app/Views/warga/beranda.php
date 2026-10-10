<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- ======================================================== -->
<!-- 1. HERO SECTION (Desktop Landing Page & Mobile Adaptable) -->
<!-- ======================================================== -->
<section class="w-full bg-gradient-to-b from-teal-50/70 via-white to-slate-50/40 border-b border-slate-200/60 pt-6 pb-10 md:pt-16 md:pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Hero Content (col-span-7) -->
            <div class="lg:col-span-7 space-y-4 md:space-y-6 text-left">
                
                <!-- Institutional Tag -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-100/70 text-desentra-teal border border-teal-200/60 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-desentra-orange animate-pulse"></span>
                    <span>Portal Resmi Layanan & Informasi Desa</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-slate-600 font-medium"><?= esc($villageName) ?></span>
                </div>

                <!-- Main Hero Headline -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-5xl font-black tracking-tight text-slate-900 leading-[1.15] font-sans">
                    Layanan Desa Lebih <span class="text-desentra-teal underline decoration-desentra-turquoise/40 decoration-4">Mudah</span>, Cepat, dan <span class="text-desentra-orange">Transparan</span>.
                </h1>

                <!-- Subtitle -->
                <p class="text-xs sm:text-sm md:text-base text-slate-600 leading-relaxed max-w-2xl font-normal">
                    Pusat panduan resmi pengurusan surat dan dokumen desa. Dilengkapi <strong>interactive checklist berkas</strong>, konsultasi cerdas 24/7 bersama <strong>Desentra AI</strong>, dan pelacakan pengaduan warga — <strong>100% Gratis & Bebas Calo</strong>.
                </p>

                <!-- Search Bar Integrated in Hero -->
                <div class="pt-1 max-w-xl">
                    <form action="<?= base_url('layanan') ?>" method="get" class="relative flex items-center bg-white rounded-2xl md:rounded-3xl border border-slate-200 shadow-md shadow-slate-200/50 p-1.5 focus-within:ring-2 focus-within:ring-desentra-teal/30 focus-within:border-desentra-teal transition-all">
                        <svg class="w-5 h-5 text-desentra-teal ml-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="q" placeholder="Cari surat (SKTM, KTP, KK, Akta Kelahiran, Usaha)..." 
                               class="w-full px-3 py-2 text-xs md:text-sm font-semibold text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none">
                        <button type="submit" class="px-5 py-2.5 rounded-xl md:rounded-2xl bg-gradient-to-r from-desentra-teal to-desentra-turquoise text-white text-xs md:text-sm font-bold shadow-xs hover:opacity-95 active:scale-95 transition-all shrink-0">
                            Cari Panduan
                        </button>
                    </form>

                    <!-- Popular Tags -->
                    <div class="flex items-center gap-2 pt-2.5 text-[11px] text-slate-500 overflow-x-auto no-scrollbar">
                        <span class="font-bold text-slate-400 shrink-0">Pencarian Populer:</span>
                        <a href="<?= base_url('layanan/detail/surat-keterangan-tidak-mampu') ?>" class="hover:text-desentra-teal underline decoration-slate-300 shrink-0">SKTM</a>
                        <span class="text-slate-300">•</span>
                        <a href="<?= base_url('layanan/detail/pengantar-ktp-kk-baru') ?>" class="hover:text-desentra-teal underline decoration-slate-300 shrink-0">KTP & KK</a>
                        <span class="text-slate-300">•</span>
                        <a href="<?= base_url('layanan/detail/pengantar-akta-kelahiran') ?>" class="hover:text-desentra-teal underline decoration-slate-300 shrink-0">Akta Lahir</a>
                        <span class="text-slate-300">•</span>
                        <a href="<?= base_url('pengaduan') ?>" class="hover:text-desentra-orange underline decoration-slate-300 shrink-0">Lapor Warga</a>
                    </div>
                </div>

                <!-- Trust Badges (Landing Page Pillars) -->
                <div class="grid grid-cols-3 gap-3 pt-3 max-w-lg border-t border-slate-200/80">
                    <div class="space-y-0.5">
                        <span class="text-base md:text-lg font-black text-desentra-teal">Rp 0</span>
                        <p class="text-[10px] md:text-xs text-slate-500 font-medium">Bebas Pungli & Calo</p>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-base md:text-lg font-black text-desentra-orange">24 / 7</span>
                        <p class="text-[10px] md:text-xs text-slate-500 font-medium">AI Siap Jawab Kapan Saja</p>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-base md:text-lg font-black text-slate-800">100%</span>
                        <p class="text-[10px] md:text-xs text-slate-500 font-medium">SOP Resmi Terverifikasi</p>
                    </div>
                </div>

            </div>

            <!-- Right Hero Card (col-span-5) - Landing Page Interactive Preview -->
            <div class="lg:col-span-5">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    
                    <!-- Decorative Background Glow -->
                    <div class="absolute -top-6 -left-6 w-72 h-72 bg-desentra-teal/15 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-6 -right-6 w-72 h-72 bg-desentra-orange/15 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Main Showcase Card -->
                    <div class="relative bg-white border border-slate-200/90 rounded-3xl p-6 shadow-xl space-y-4">
                        
                        <!-- Top Bar in Card -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block animate-ping"></span>
                                <span class="text-xs font-bold text-slate-700">Pelayanan Loket Desa Aktif</span>
                            </div>
                            <span class="text-[11px] font-mono text-slate-400">08.00 – 15.00 WIB</span>
                        </div>

                        <!-- Simulated AI Smart Recommendation -->
                        <div class="bg-gradient-to-br from-teal-50/80 to-emerald-50/60 rounded-2xl p-4 border border-teal-100 space-y-2">
                            <div class="flex items-center justify-between text-xs text-desentra-teal font-extrabold">
                                <span class="flex items-center gap-1.5">
                                    <span>🤖</span>
                                    <span>Desentra Assistant</span>
                                </span>
                                <span class="text-[10px] bg-white px-2 py-0.5 rounded-full text-desentra-teal font-bold border border-teal-200/60">Terverifikasi</span>
                            </div>
                            <p class="text-xs text-slate-700 font-medium leading-relaxed">
                                "Halo warga! Ingin mengurus SKTM atau Akta Kelahiran hari ini? Ceklis seluruh berkas di ponsel Anda agar tidak perlu bolak-balik."
                            </p>
                            <div class="pt-1">
                                <a href="<?= base_url('tanya') ?>" class="inline-flex items-center gap-1 text-[11px] font-bold text-desentra-teal hover:underline">
                                    <span>Tanya prosedur surat lainnya</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>

                        <!-- Quick Shortcuts in Card -->
                        <div class="space-y-2 pt-1">
                            <span class="text-[11px] font-black uppercase tracking-wider text-slate-400 block">Akses Cepat Warga</span>
                            <div class="grid grid-cols-2 gap-2.5">
                                <a href="<?= base_url('layanan/detail/surat-keterangan-tidak-mampu') ?>" class="p-3 rounded-2xl border border-slate-200/80 hover:border-desentra-teal/50 hover:bg-slate-50 transition-all flex items-center gap-2.5 group">
                                    <div class="w-8 h-8 rounded-xl bg-teal-50 text-desentra-teal flex items-center justify-center font-bold text-xs shrink-0 group-hover:bg-desentra-teal group-hover:text-white transition-colors">
                                        📄
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="text-xs font-bold text-slate-800 truncate">Surat SKTM</h4>
                                        <span class="text-[10px] text-emerald-600 font-semibold">Gratis • 15 Menit</span>
                                    </div>
                                </a>

                                <a href="<?= base_url('layanan/detail/pengantar-ktp-kk-baru') ?>" class="p-3 rounded-2xl border border-slate-200/80 hover:border-desentra-orange/50 hover:bg-slate-50 transition-all flex items-center gap-2.5 group">
                                    <div class="w-8 h-8 rounded-xl bg-orange-50 text-desentra-orange flex items-center justify-center font-bold text-xs shrink-0 group-hover:bg-desentra-orange group-hover:text-white transition-colors">
                                        💳
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="text-xs font-bold text-slate-800 truncate">KTP & KK</h4>
                                        <span class="text-[10px] text-emerald-600 font-semibold">Gratis • 20 Menit</span>
                                    </div>
                                </a>

                                <a href="<?= base_url('layanan/detail/pengantar-akta-kelahiran') ?>" class="p-3 rounded-2xl border border-slate-200/80 hover:border-amber-400 hover:bg-slate-50 transition-all flex items-center gap-2.5 group">
                                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-desentra-gold flex items-center justify-center font-bold text-xs shrink-0 group-hover:bg-desentra-gold group-hover:text-white transition-colors">
                                        👶
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="text-xs font-bold text-slate-800 truncate">Akta Kelahiran</h4>
                                        <span class="text-[10px] text-emerald-600 font-semibold">Gratis • Resmi</span>
                                    </div>
                                </a>

                                <a href="<?= base_url('pengaduan') ?>" class="p-3 rounded-2xl border border-slate-200/80 hover:border-sky-400 hover:bg-slate-50 transition-all flex items-center gap-2.5 group">
                                    <div class="w-8 h-8 rounded-xl bg-sky-50 text-desentra-blue flex items-center justify-center font-bold text-xs shrink-0 group-hover:bg-desentra-blue group-hover:text-white transition-colors">
                                        📢
                                    </div>
                                    <div class="overflow-hidden">
                                        <h4 class="text-xs font-bold text-slate-800 truncate">Lapor Masalah</h4>
                                        <span class="text-[10px] text-desentra-orange font-semibold">Dapat Kode Tiket</span>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ======================================================== -->
<!-- 2. KEUNGGULAN DESENTRA (Landing Page Value Proposition) -->
<!-- ======================================================== -->
<section class="w-full py-14 md:py-20 bg-white border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <span class="text-xs font-extrabold uppercase tracking-widest text-desentra-teal bg-teal-50 px-3 py-1 rounded-full border border-teal-100">
                Keunggulan Desentra
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-slate-900 font-sans">
                Standar Baru Transparansi Pelayanan Publik Desa
            </h2>
            <p class="text-xs sm:text-sm md:text-base text-slate-500 font-normal leading-relaxed">
                Kami menyederhanakan alur birokrasi desa agar setiap warga memiliki kepastian syarat, waktu, dan biaya sebelum melangkah ke kantor desa.
            </p>
        </div>

        <!-- 3 Feature Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            
            <!-- Card 1: Mudah & Mandiri -->
            <div class="bg-gradient-to-br from-[#FEF8F0] via-[#FDF3E7] to-[#FCECD8] border border-desentra-orange/30 rounded-3xl p-6 md:p-8 shadow-xs relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-desentra-orange/20 flex items-center justify-center text-desentra-orange mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="space-y-2">
                    <h3 class="font-extrabold text-lg md:text-xl text-slate-900">Mudah & Checklist Mandiri</h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-normal">
                        Rincian berkas persyaratan tersusun gamblang dengan fitur <em>interactive checklist</em> yang tersimpan di perangkat warga. Datang ke kantor desa tanpa risiko berkas tertinggal.
                    </p>
                </div>
            </div>

            <!-- Card 2: Aman & Bebas Calo -->
            <div class="bg-gradient-to-br from-[#E6F7F5] via-[#DBF3F1] to-[#CDEFEA] border border-desentra-teal/30 rounded-3xl p-6 md:p-8 shadow-xs relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-desentra-teal/20 flex items-center justify-center text-desentra-teal mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="space-y-2">
                    <h3 class="font-extrabold text-lg md:text-xl text-slate-900">Aman & Bebas Calo</h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-normal">
                        Setiap rujukan langkah bersumber langsung dari Peraturan Bupati dan Standar Operasional Prosedur (SOP) resmi yang telah ditinjau verifikator desa. Tanpa perantara ilegal.
                    </p>
                </div>
            </div>

            <!-- Card 3: Transparan & Akuntabel -->
            <div class="bg-gradient-to-br from-[#2F586C] via-[#3C7087] to-[#1469A5] border border-desentra-blue rounded-3xl p-6 md:p-8 text-white shadow-xs relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-xs shadow-xs border border-white/20 flex items-center justify-center text-white mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="space-y-2">
                    <h3 class="font-extrabold text-lg md:text-xl text-white">Transparan & Bebas Pungli</h3>
                    <p class="text-xs md:text-sm text-white/90 leading-relaxed font-normal">
                        Seluruh permohonan surat bertarif resmi Rp 0 (gratis). Dilengkapi sistem pelacakan kode tiket untuk memantau proses verifikasi dan tindak lanjut laporan pengaduan Anda.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ======================================================== -->
<!-- 3. KATALOG LAYANAN POPULER DESA (Showcase Section) -->
<!-- ======================================================== -->
<section class="w-full py-14 md:py-20 bg-slate-50/60 border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-extrabold uppercase tracking-widest text-desentra-teal bg-teal-50 px-3 py-1 rounded-full border border-teal-100">
                    Katalog Layanan
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-slate-900 font-sans">
                    Layanan Administrasi Populer Warga
                </h2>
                <p class="text-xs md:text-sm text-slate-500 font-medium">
                    Panduan syarat berkas dan langkah pengurusan surat yang paling sering dibutuhkan masyarakat.
                </p>
            </div>

            <a href="<?= base_url('layanan') ?>" class="inline-flex items-center gap-2 text-xs md:text-sm font-extrabold text-desentra-teal hover:text-teal-700 hover:underline shrink-0">
                <span>Lihat Seluruh Katalog Layanan</span>
                <span>→</span>
            </a>
        </div>

        <!-- 3 Columns Cards Grid on Desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($popularGuides as $guide): ?>
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-xs hover:border-desentra-teal/50 hover:shadow-lg transition-all flex flex-col justify-between gap-5 group">
                <div class="space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <span class="inline-block text-[11px] font-bold text-desentra-teal bg-desentra-teal/10 px-2.5 py-1 rounded-lg">
                            <?= esc($guide['category']) ?>
                        </span>
                        <div class="w-10 h-10 rounded-2xl bg-teal-50 text-desentra-teal flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <h3 class="font-extrabold text-base md:text-lg text-slate-900 group-hover:text-desentra-teal transition-colors leading-snug">
                        <?= esc($guide['title']) ?>
                    </h3>

                    <p class="text-xs md:text-sm text-slate-500 line-clamp-2 leading-relaxed">
                        <?= esc($guide['summary']) ?>
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs">
                        <span class="text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-100 text-[11px]">
                            <?= esc($guide['fee_description']) ?>
                        </span>
                        <span class="text-slate-400 text-[11px]">
                            <?= esc($guide['estimated_duration'] ?? '15 Menit') ?>
                        </span>
                    </div>

                    <a href="<?= base_url('layanan/detail/' . $guide['slug']) ?>" 
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-desentra-teal/10 text-desentra-teal text-xs font-bold hover:bg-desentra-teal hover:text-white transition-all shadow-2xs">
                        <span>Lihat Syarat</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ======================================================== -->
<!-- 4. SPOTLIGHT DESENTRA AI ASSISTANT (Landing Feature Section) -->
<!-- ======================================================== -->
<section class="w-full bg-gradient-to-r from-desentra-teal via-[#008683] to-[#009E94] text-white py-16 md:py-24 relative overflow-hidden">
    
    <!-- Background Sparkles -->
    <div class="absolute top-10 right-10 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            
            <!-- Left Info (col-span-7) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-white text-xs font-bold backdrop-blur-xs">
                    <span class="text-desentra-gold">✦</span>
                    <span>DIDUKUNG GOOGLE GEMINI AI & DOKUMEN RESMI DESA</span>
                </div>

                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight">
                    Konsultasi Prosedur Desa Kapan Saja, 24 Jam Nonstop.
                </h2>

                <p class="text-xs sm:text-sm md:text-base text-white/90 leading-relaxed font-normal max-w-xl">
                    Warga tidak perlu menunggu jam buka loket kantor desa hanya untuk menanyakan syarat berkas. Desentra Assistant menjawab secara presisi menggunakan teknologi pencarian regulasi cerdas.
                </p>

                <!-- Value Checks -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-center gap-3 text-xs md:text-sm text-white/95">
                        <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center shrink-0 text-emerald-300 font-bold">✓</span>
                        <span><strong>Bebas Halusinasi:</strong> Jawaban disaring dari database Peraturan Bupati & SOP resmi desa.</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs md:text-sm text-white/95">
                        <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center shrink-0 text-emerald-300 font-bold">✓</span>
                        <span><strong>Aman & Terjaga:</strong> Tidak meminta NIK, nomor rekening, atau informasi pribadi sensitif warga.</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs md:text-sm text-white/95">
                        <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center shrink-0 text-emerald-300 font-bold">✓</span>
                        <span><strong>Langsung di Ponsel:</strong> Konsultasikan syarat surat sambil menyiapkan berkas dari rumah.</span>
                    </div>
                </div>

                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <a href="<?= base_url('tanya') ?>" class="px-6 py-3.5 rounded-2xl bg-white text-desentra-teal font-extrabold text-xs md:text-sm shadow-lg shadow-teal-950/20 hover:bg-orange-50 hover:text-desentra-orange active:scale-95 transition-all">
                        Mulai Konsultasi AI Sekarang →
                    </a>
                    <span class="text-xs text-white/80">Gratis • Tanpa Perlu Daftar Akun</span>
                </div>
            </div>

            <!-- Right Interactive Chat Mockup (col-span-5) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl p-6 text-slate-800 shadow-2xl space-y-4 max-w-md mx-auto">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-desentra-teal text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                AI
                            </div>
                            <div>
                                <h4 class="font-extrabold text-xs text-slate-900">Desentra AI Assistant</h4>
                                <span class="text-[10px] text-emerald-600 font-bold">● Terhubung ke SOP Desa</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono text-slate-400">RAG v1.0</span>
                    </div>

                    <!-- User Bubble -->
                    <div class="flex justify-end">
                        <div class="bg-gradient-to-r from-desentra-teal to-desentra-turquoise text-white rounded-2xl rounded-tr-xs px-4 py-2.5 text-xs font-medium max-w-[85%] shadow-xs">
                            Apa saja syarat buat SKTM untuk beasiswa anak saya?
                        </div>
                    </div>

                    <!-- AI Bubble -->
                    <div class="flex items-start gap-2.5">
                        <div class="bg-slate-50 border border-slate-200/90 rounded-2xl rounded-tl-xs p-4 text-xs space-y-2 text-slate-700 leading-relaxed">
                            <p class="font-bold text-slate-900">
                                Berdasarkan SOP Pelayanan Kantor Desa Sukamaju:
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-slate-600 text-[11px]">
                                <li>Surat Pengantar dari Ketua RT dan RW setempat.</li>
                                <li>Fotokopi Kartu Keluarga (KK) & KTP pemohon.</li>
                                <li>Surat Keterangan Penghasilan / Pernyataan Prasejahtera.</li>
                            </ul>
                            <div class="pt-1 flex items-center justify-between text-[10px] text-emerald-700 font-bold border-t border-slate-200/60">
                                <span>Biaya: Rp 0 (Gratis)</span>
                                <span>Waktu: 15–30 Menit</span>
                            </div>
                        </div>
                    </div>

                    <a href="<?= base_url('tanya') ?>" class="block text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-desentra-teal rounded-xl text-xs font-bold transition-colors">
                        Buka Ruang Chat Lengkap →
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ======================================================== -->
<!-- 5. KABAR & KETERBUKAAN INFORMASI DESA -->
<!-- ======================================================== -->
<section class="w-full py-14 md:py-20 bg-white border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-extrabold uppercase tracking-widest text-desentra-orange bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                    Keterbukaan Informasi Publik
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-slate-900 font-sans">
                    Kabar, Agenda, & Pengumuman Desa
                </h2>
                <p class="text-xs md:text-sm text-slate-500 font-medium">
                    Pembaruan informasi terkini seputar program desa, jadwal posyandu, dan penyaluran bantuan.
                </p>
            </div>

            <a href="<?= base_url('info-desa') ?>" class="inline-flex items-center gap-2 text-xs md:text-sm font-extrabold text-desentra-teal hover:text-teal-700 hover:underline shrink-0">
                <span>Lihat Semua Kabar Desa</span>
                <span>→</span>
            </a>
        </div>

        <!-- 3 Columns Articles Grid on Desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($latestInfos as $info): ?>
            <a href="<?= base_url('info-desa/detail/' . $info['slug']) ?>" class="group bg-white border border-slate-200/90 rounded-3xl overflow-hidden shadow-xs hover:border-desentra-teal/50 hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                    <!-- Thumbnail Poster -->
                    <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100 border-b border-slate-100 relative">
                        <?php if (!empty($info['banner_image'])): ?>
                        <img src="<?= base_url($info['banner_image']) ?>" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-teal-50 to-slate-100 flex items-center justify-center text-desentra-teal">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <?php endif; ?>

                        <!-- Category Overlay Pill -->
                        <span class="absolute top-3 left-3 text-[10px] font-bold text-desentra-orange bg-white/95 backdrop-blur-xs px-2.5 py-1 rounded-full uppercase tracking-wider shadow-xs">
                            <?= esc($info['category']) ?>
                        </span>
                    </div>

                    <div class="p-6 space-y-2.5">
                        <span class="text-[11px] text-slate-400 font-medium block">
                            <?= date('d F Y', strtotime($info['published_at'])) ?>
                        </span>
                        <h3 class="font-extrabold text-base md:text-lg text-slate-900 group-hover:text-desentra-teal transition-colors leading-snug line-clamp-2">
                            <?= esc($info['title']) ?>
                        </h3>
                        <p class="text-xs md:text-sm text-slate-500 line-clamp-2 leading-relaxed">
                            <?= esc($info['content']) ?>
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-desentra-teal">
                    <span>Baca Selengkapnya</span>
                    <span>→</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ======================================================== -->
<!-- 6. KANAL PENGADUAN & ASPIRASI (Civic CTA Banner) -->
<!-- ======================================================== -->
<section class="w-full py-14 md:py-20 bg-slate-50/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 md:p-14 text-white shadow-xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
            
            <div class="space-y-4 max-w-2xl text-left">
                <span class="text-xs font-bold text-desentra-orange bg-orange-950/60 border border-orange-500/30 px-3 py-1 rounded-full uppercase tracking-wider">
                    Suara & Aspirasi Warga
                </span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight leading-tight">
                    Ada Kendala di Lingkungan atau Layanan Desa?
                </h2>
                <p class="text-xs sm:text-sm md:text-base text-slate-300 leading-relaxed font-normal">
                    Laporkan kerusakan fasilitas umum, lampu jalan, kebersihan lingkungan, atau keluhan administrasi secara langsung. Setiap laporan memperoleh <strong>kode tiket unik</strong> untuk memantau status penyelesaiannya secara transparan.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3.5 shrink-0 w-full lg:w-auto">
                <a href="<?= base_url('pengaduan') ?>" class="w-full sm:w-auto text-center px-6 py-3.5 rounded-2xl bg-gradient-to-r from-desentra-orange to-[#F29F28] text-white font-extrabold text-xs md:text-sm shadow-md shadow-orange-900/40 hover:opacity-95 active:scale-95 transition-all">
                    Kirim Laporan Pengaduan →
                </a>
                <a href="<?= base_url('pengaduan/status') ?>" class="w-full sm:w-auto text-center px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs md:text-sm backdrop-blur-xs transition-all">
                    Lacak Kode Tiket
                </a>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
