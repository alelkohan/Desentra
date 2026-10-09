<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-5 py-5 space-y-6">

    <!-- Header Sesuai Wireframe: Judul Besar Desentra + Subtitle Area Desa + Search Icon Kanan Atas -->
    <section class="flex items-start justify-between gap-3">
        <div class="space-y-1">
            <h1 class="text-3xl font-black tracking-tight text-slate-900 font-sans">
                Desentra
            </h1>
            <p class="text-xs text-slate-500 font-medium leading-relaxed max-w-[280px]">
                <?= esc(env('DESENTRA_DISTRICT_NAME', 'Platform pusat layanan masyarakat')) ?>  
                <span class="block text-slate-700 font-semibold"><?= esc($villageName) ?></span>
            </p>
        </div>

        <a href="<?= base_url('layanan') ?>" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-xs hover:border-desentra-teal hover:text-desentra-teal transition-all shrink-0 mt-1" title="Cari Panduan">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </a>
    </section>

    <!-- 3 KARTU NILAI UTAMA SESUAI WIREFRAME SKETSA -->
    <section class="space-y-3.5">
        
        <!-- Baris Atas: 2 Kartu Berdampingan (Mudah & Aman) -->
        <div class="grid grid-cols-2 gap-3.5">
            
            <!-- 1. KARTU MUDAH -->
            <div class="bg-gradient-to-br from-[#FEF8F0] via-[#FDF3E7] to-[#FCECD8] border border-desentra-orange/25 rounded-3xl p-4 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[145px] group">
                <!-- Ornamen Garis/Gelombang Abstrak Sesuai Sketsa -->
                <div class="absolute -right-3 -top-3 w-20 h-20 opacity-30 text-desentra-orange pointer-events-none">
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <path d="M20,50 C20,20 50,20 50,50 C50,80 80,80 80,50 C80,20 100,20 100,50 C100,90 20,90 20,50 Z" />
                    </svg>
                </div>
                
                <div class="w-9 h-9 rounded-2xl bg-white shadow-xs border border-desentra-orange/20 flex items-center justify-center text-desentra-orange z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <div class="z-10 mt-3">
                    <h3 class="font-extrabold text-base text-slate-900 leading-none">Mudah</h3>
                    <p class="text-[11px] text-slate-600 font-medium mt-1.5 leading-snug">
                        Syarat jelas & checklist langsung di ponsel.
                    </p>
                </div>
            </div>

            <!-- 2. KARTU AMAN -->
            <div class="bg-gradient-to-br from-[#E6F7F5] via-[#DBF3F1] to-[#CDEFEA] border border-desentra-teal/25 rounded-3xl p-4 shadow-xs relative overflow-hidden flex flex-col justify-between min-h-[145px] group">
                <!-- Ornamen Gambar Hati / Lindung Sesuai Sketsa -->
                <div class="absolute -right-3 -top-2 w-20 h-20 opacity-25 text-desentra-teal pointer-events-none">
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <path d="M50 85 C20 60 10 35 25 20 C40 5 50 25 50 25 C50 25 60 5 75 20 C90 35 80 60 50 85 Z"/>
                    </svg>
                </div>

                <div class="w-9 h-9 rounded-2xl bg-white shadow-xs border border-desentra-teal/20 flex items-center justify-center text-desentra-teal z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>

                <div class="z-10 mt-3">
                    <h3 class="font-extrabold text-base text-slate-900 leading-none">Aman</h3>
                    <p class="text-[11px] text-slate-600 font-medium mt-1.5 leading-snug">
                        Bebas calo. Rujukan SOP & hukum terverifikasi.
                    </p>
                </div>
            </div>

        </div>

        <!-- Baris Bawah: 1 Kartu Lebar (Up to date & Transparan) -->
        <div class="bg-gradient-to-r from-[#2F586C] via-[#3C7087] to-[#1469A5] border border-desentra-blue rounded-3xl p-4 text-white shadow-sm relative overflow-hidden">
            <!-- Ilustrasi Kaca Pembesar & Lembar Dokumen Sesuai Sketsa Wireframe -->
            <div class="absolute right-3 top-3 w-28 h-28 opacity-15 text-white pointer-events-none">
                <svg viewBox="0 0 100 100" fill="currentColor">
                    <rect x="25" y="15" width="45" height="60" rx="6" />
                    <circle cx="65" cy="65" r="18" fill="none" stroke="currentColor" stroke-width="8"/>
                    <line x1="78" y1="78" x2="95" y2="95" stroke="currentColor" stroke-width="8" stroke-linecap="round"/>
                </svg>
            </div>

            <div class="relative z-10 space-y-1.5 max-w-[82%]">
                <div class="inline-flex items-center gap-1.5 text-[10px] font-bold tracking-wider uppercase text-desentra-mint-light">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Standar Pelayanan</span>
                </div>
                <h3 class="font-extrabold text-base tracking-tight text-white">
                    Up to date & Transparan
                </h3>
                <p class="text-[11px] text-white/90 leading-relaxed font-normal">
                    Pembaruan regulasi berkala dengan tanggal tinjauan jelas dan transparansi biaya resmi Rp 0 (gratis).
                </p>
            </div>
        </div>

    </section>

    <!-- MENU AKSI CEPAT LINGKARAN (BSI Style Circular Quick Action Menu) -->
    <section class="bg-white border border-slate-200/80 rounded-3xl p-4 shadow-xs">
        <div class="flex items-center justify-between mb-3 px-1">
            <span class="text-xs font-black text-slate-900 tracking-tight">Pintasan Layanan Warga</span>
            <span class="text-[10px] font-bold text-desentra-teal uppercase tracking-wider">Cepat & Resmi</span>
        </div>
        <div class="grid grid-cols-4 gap-2 text-center">
            <!-- 1. SKTM -->
            <a href="<?= base_url('layanan/detail/surat-keterangan-tidak-mampu') ?>" class="group flex flex-col items-center space-y-1.5">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center text-desentra-teal shadow-2xs group-hover:bg-desentra-teal group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-slate-700 group-hover:text-desentra-teal transition-colors">SKTM</span>
            </a>

            <!-- 2. KTP / KK -->
            <a href="<?= base_url('layanan/detail/pengantar-ktp-kk-baru') ?>" class="group flex flex-col items-center space-y-1.5">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 border border-orange-100 flex items-center justify-center text-desentra-orange shadow-2xs group-hover:bg-desentra-orange group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-slate-700 group-hover:text-desentra-orange transition-colors">KTP & KK</span>
            </a>

            <!-- 3. Akta Lahir -->
            <a href="<?= base_url('layanan/detail/pengantar-akta-kelahiran') ?>" class="group flex flex-col items-center space-y-1.5">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-desentra-gold shadow-2xs group-hover:bg-desentra-gold group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-slate-700 group-hover:text-desentra-gold transition-colors">Akta Lahir</span>
            </a>

            <!-- 4. Pengaduan -->
            <a href="<?= base_url('pengaduan') ?>" class="group flex flex-col items-center space-y-1.5">
                <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center text-desentra-blue shadow-2xs group-hover:bg-desentra-blue group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <span class="text-[11px] font-bold text-slate-700 group-hover:text-desentra-blue transition-colors">Pengaduan</span>
            </a>
        </div>
    </section>

    <!-- Tanya AI Floating Banner (BSI BYOND Gradient) -->
    <section>
        <div class="bg-gradient-to-r from-desentra-teal via-[#009E94] to-desentra-turquoise rounded-3xl p-4 text-white shadow-md shadow-desentra-teal/20 flex items-center justify-between gap-3">
            <div class="space-y-1">
                <span class="text-[10px] font-bold bg-white/20 px-2 py-0.5 rounded-full uppercase tracking-wider">Tanya Kapan Saja</span>
                <h3 class="font-extrabold text-sm">Butuh Panduan Surat?</h3>
                <p class="text-[11px] text-white/90 leading-snug">
                    Tanya AI Desentra untuk jawaban instan bersumber resmi.
                </p>
            </div>
            <a href="<?= base_url('tanya') ?>" class="px-3.5 py-2 rounded-2xl bg-white text-desentra-teal font-extrabold text-xs shadow-sm shrink-0 active:scale-95 transition-transform hover:bg-orange-50 hover:text-desentra-orange">
                Mulai Chat →
            </a>
        </div>
    </section>

    <!-- Layanan Populer Desa Sesuai Wireframe Format -->
    <section class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-sm text-slate-800">Layanan Populer</h2>
            <a href="<?= base_url('layanan') ?>" class="text-xs font-bold text-desentra-teal hover:underline">Lihat Semua</a>
        </div>

        <div class="space-y-3">
            <?php foreach ($popularGuides as $guide): ?>
            <!-- Card Layanan Style Sesuai Sketsa -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-4 shadow-xs hover:border-desentra-teal/40 transition-all flex items-center justify-between gap-3 group">
                <div class="space-y-1.5 flex-1">
                    <span class="inline-block text-[10px] font-bold text-desentra-teal bg-desentra-teal/10 px-2 py-0.5 rounded-md leading-none">
                        <?= esc($guide['category']) ?>
                    </span>
                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-desentra-teal transition-colors leading-tight">
                        <?= esc($guide['title']) ?>
                    </h3>
                    <p class="text-[11px] text-slate-500 line-clamp-1">
                        <?= esc($guide['summary']) ?>
                    </p>
                    <div class="pt-1">
                        <a href="<?= base_url('layanan/detail/' . $guide['slug']) ?>" 
                           class="inline-block px-4 py-1.5 rounded-full bg-desentra-teal/10 text-desentra-teal border border-desentra-teal/25 text-xs font-bold hover:bg-desentra-teal hover:text-white transition-all shadow-2xs">
                            Lihat
                        </a>
                    </div>
                </div>

                <!-- Ilustrasi Dokumen Kanan Sesuai Sketsa Wireframe -->
                <div class="w-16 h-16 rounded-2xl bg-teal-50/70 border border-teal-100 flex items-center justify-center shrink-0 text-slate-400">
                    <svg class="w-8 h-8 text-desentra-teal/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Info & Pengumuman Desa Terkini -->
    <section class="space-y-3 pb-2">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-sm text-slate-800">Kabar & Agenda Desa</h2>
            <a href="<?= base_url('info-desa') ?>" class="text-xs font-bold text-desentra-teal hover:underline">Semua Info</a>
        </div>

        <div class="space-y-3">
            <?php foreach ($latestInfos as $info): ?>
            <a href="<?= base_url('info-desa/detail/' . $info['slug']) ?>" class="block bg-white border border-slate-200/90 rounded-3xl p-3.5 shadow-xs hover:border-desentra-teal/40 transition-all">
                <div class="flex items-center gap-3">
                    <?php if (!empty($info['banner_image'])): ?>
                    <img src="<?= base_url($info['banner_image']) ?>" alt="Thumbnail" class="w-16 h-16 rounded-2xl object-cover shrink-0 border border-slate-100">
                    <?php endif; ?>
                    <div class="space-y-1 flex-1 overflow-hidden">
                        <div class="flex items-center justify-between text-[10px] text-slate-400">
                            <span class="font-bold text-desentra-orange uppercase tracking-wider"><?= esc($info['category']) ?></span>
                            <span><?= date('d M Y', strtotime($info['published_at'])) ?></span>
                        </div>
                        <h4 class="font-bold text-xs text-slate-900 truncate"><?= esc($info['title']) ?></h4>
                        <p class="text-[11px] text-slate-500 line-clamp-1 leading-relaxed"><?= esc($info['content']) ?></p>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

</div>
<?= $this->endSection() ?>
