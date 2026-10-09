<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 space-y-4 pb-28">

    <!-- 1. Hero Welcome Greeting Banner (BSI High-End Gradient & Glass Depth) -->
    <div class="relative overflow-hidden rounded-3xl p-5 bg-gradient-to-br from-[#008683] via-[#007774] to-[#009E94] text-white shadow-lg shadow-teal-950/15">
        
        <!-- Decorative Ambient Orbs -->
        <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute right-12 top-0 w-24 h-24 rounded-full bg-desentra-turquoise/20 blur-xl pointer-events-none"></div>
        <div class="absolute -left-6 -top-6 w-28 h-28 rounded-full bg-desentra-gold/15 blur-xl pointer-events-none"></div>

        <div class="relative z-10 space-y-2.5">
            <!-- Top Tag & Date -->
            <div class="flex items-center justify-between text-[11px]">
                <div class="inline-flex items-center gap-1.5 bg-black/20 backdrop-blur-md px-3 py-1 rounded-full border border-white/15">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-extrabold uppercase tracking-wider text-[10px] text-teal-100">Pusat Kendali Operasional</span>
                </div>
                <div class="inline-flex items-center gap-1 text-teal-100/90 font-semibold bg-white/10 px-2.5 py-0.5 rounded-full backdrop-blur-sm">
                    <svg class="w-3 h-3 text-desentra-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span><?= date('d M Y') ?></span>
                </div>
            </div>

            <!-- Greeting Headline -->
            <div>
                <?php
                $rawName = session('admin_name') ?? 'Petugas';
                // Bersihkan suffix seperti (Administrator) untuk sapaan hangat
                $cleanName = trim(preg_replace('/\s*\(.*?\)/', '', $rawName));
                ?>
                <h1 class="text-xl font-black tracking-tight leading-tight flex items-center gap-2">
                    <span>Selamat Bertugas, <?= esc($cleanName) ?></span>
                    <span class="inline-block transform hover:rotate-12 transition-transform">👋</span>
                </h1>
                <p class="text-xs text-teal-100/80 leading-relaxed font-medium mt-1">
                    Kelola panduan resmi, tindak lanjuti pengaduan warga, & perbarui basis informasi desa secara real-time.
                </p>
            </div>
        </div>
    </div>

    <!-- 2. RINGKASAN STATISTIK (Ultra-Aesthetic FinTech BSI Cards) -->
    <section class="space-y-2">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-600 flex items-center gap-1.5">
                <span>Ringkasan Metrik</span>
                <span class="w-1.5 h-1.5 rounded-full bg-desentra-teal"></span>
            </h2>
            <span class="text-[10px] text-slate-400 font-semibold">Real-time Data</span>
        </div>

        <div class="grid grid-cols-2 gap-2.5">
            
            <!-- 1. Panduan Layanan (Teal Theme) -->
            <a href="<?= base_url('admin/layanan') ?>" 
               class="group relative bg-white border border-slate-200/90 hover:border-desentra-teal/60 rounded-3xl p-3.5 shadow-[0_2px_10px_-2px_rgba(15,23,42,0.04)] hover:shadow-[0_8px_20px_-4px_rgba(0,134,131,0.12)] active:scale-[0.985] transition-all flex flex-col justify-between overflow-hidden">
                <div class="absolute -top-8 -right-8 w-20 h-20 rounded-full bg-teal-50/70 group-hover:bg-teal-100/60 transition-colors pointer-events-none"></div>

                <div class="flex items-center justify-between relative z-10 mb-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 group-hover:text-desentra-teal transition-colors">
                        Panduan
                    </span>
                    <div class="w-7 h-7 rounded-xl bg-teal-50 text-desentra-teal border border-teal-100/80 flex items-center justify-center font-bold text-xs group-hover:scale-110 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative z-10">
                    <span class="text-3xl font-black text-slate-900 leading-none block tracking-tight">
                        <?= $stats['publishedGuides'] ?>
                    </span>
                    <div class="flex flex-col gap-1 mt-2">
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100/80 px-2 py-0.5 rounded-md inline-block w-fit">
                            ✓ <?= $stats['totalGuides'] ?> Total Panduan
                        </span>
                        <?php if ($stats['pendingGuides'] > 0): ?>
                        <span class="text-[9px] font-extrabold text-amber-800 bg-amber-50 border border-amber-200/80 px-2 py-0.5 rounded-md inline-block w-fit animate-pulse">
                            ⏳ <?= $stats['pendingGuides'] ?> Butuh Review
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>

            <!-- 2. Info Desa (Cyan / Blue Theme) -->
            <a href="<?= base_url('admin/info-desa') ?>" 
               class="group relative bg-white border border-slate-200/90 hover:border-cyan-400/60 rounded-3xl p-3.5 shadow-[0_2px_10px_-2px_rgba(15,23,42,0.04)] hover:shadow-[0_8px_20px_-4px_rgba(6,182,212,0.12)] active:scale-[0.985] transition-all flex flex-col justify-between overflow-hidden">
                <div class="absolute -top-8 -right-8 w-20 h-20 rounded-full bg-cyan-50/70 group-hover:bg-cyan-100/60 transition-colors pointer-events-none"></div>

                <div class="flex items-center justify-between relative z-10 mb-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 group-hover:text-cyan-600 transition-colors">
                        Info Desa
                    </span>
                    <div class="w-7 h-7 rounded-xl bg-cyan-50 text-cyan-600 border border-cyan-100/80 flex items-center justify-center font-bold text-xs group-hover:scale-110 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative z-10">
                    <span class="text-3xl font-black text-slate-900 leading-none block tracking-tight">
                        <?= $stats['activeInfos'] ?>
                    </span>
                    <div class="flex flex-col gap-1 mt-2">
                        <span class="text-[10px] font-bold text-cyan-800 bg-cyan-50 border border-cyan-100/80 px-2 py-0.5 rounded-md inline-block w-fit">
                            ✓ Aktif Tayang
                        </span>
                        <span class="text-[9px] text-slate-400 px-0.5 block">
                            <?= $stats['totalInfos'] ?> Arsip Tersimpan
                        </span>
                    </div>
                </div>
            </a>

            <!-- 3. Pengaduan Warga (BSI Warm Orange Theme) -->
            <a href="<?= base_url('admin/pengaduan') ?>" 
               class="group relative bg-white border border-slate-200/90 hover:border-desentra-orange/60 rounded-3xl p-3.5 shadow-[0_2px_10px_-2px_rgba(15,23,42,0.04)] hover:shadow-[0_8px_20px_-4px_rgba(240,143,14,0.14)] active:scale-[0.985] transition-all flex flex-col justify-between overflow-hidden">
                <div class="absolute -top-8 -right-8 w-20 h-20 rounded-full bg-orange-50/70 group-hover:bg-orange-100/60 transition-colors pointer-events-none"></div>

                <div class="flex items-center justify-between relative z-10 mb-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 group-hover:text-desentra-orange transition-colors">
                        Pengaduan
                    </span>
                    <div class="w-7 h-7 rounded-xl bg-orange-50 text-desentra-orange border border-orange-100/80 flex items-center justify-center font-bold text-xs group-hover:scale-110 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative z-10">
                    <span class="text-3xl font-black text-slate-900 leading-none block tracking-tight">
                        <?= $stats['receivedComplaints'] ?>
                    </span>
                    <div class="flex flex-col gap-1 mt-2">
                        <span class="text-[10px] font-bold text-desentra-orange bg-orange-50 border border-orange-200/80 px-2 py-0.5 rounded-md inline-block w-fit">
                            <?= $stats['receivedComplaints'] ?> Tiket Baru
                        </span>
                        <span class="text-[9px] text-slate-400 px-0.5 block">
                            <?= $stats['progressComplaints'] ?> Proses • <?= $stats['resolvedComplaints'] ?> Tuntas
                        </span>
                    </div>
                </div>
            </a>

            <!-- 4. Antrean AI / Celah RAG (Gold / Purple Theme) -->
            <a href="<?= base_url('admin/ai-antrean') ?>" 
               class="group relative bg-white border border-slate-200/90 hover:border-amber-400/60 rounded-3xl p-3.5 shadow-[0_2px_10px_-2px_rgba(15,23,42,0.04)] hover:shadow-[0_8px_20px_-4px_rgba(241,180,53,0.16)] active:scale-[0.985] transition-all flex flex-col justify-between overflow-hidden">
                <div class="absolute -top-8 -right-8 w-20 h-20 rounded-full bg-amber-50/70 group-hover:bg-amber-100/60 transition-colors pointer-events-none"></div>

                <div class="flex items-center justify-between relative z-10 mb-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 group-hover:text-amber-600 transition-colors">
                        Antrean AI
                    </span>
                    <div class="w-7 h-7 rounded-xl bg-amber-50 text-amber-600 border border-amber-100/80 flex items-center justify-center font-bold text-xs group-hover:scale-110 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative z-10">
                    <span class="text-3xl font-black text-slate-900 leading-none block tracking-tight">
                        <?= $stats['fallbackQuestions'] ?>
                    </span>
                    <div class="flex flex-col gap-1 mt-2">
                        <span class="text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-200/80 px-2 py-0.5 rounded-md inline-block w-fit">
                            <?= $stats['fallbackQuestions'] ?> Celah RAG
                        </span>
                        <span class="text-[9px] text-desentra-teal font-bold px-0.5 block group-hover:underline">
                            Tinjau Pertanyaan →
                        </span>
                    </div>
                </div>
            </a>

        </div>
    </section>

    <!-- 3. PINTASAN AKSI CEPAT (Modern CTA Buttons with Micro-Gradients) -->
    <section class="space-y-2">
        <h2 class="text-xs font-black uppercase tracking-wider text-slate-600 px-1">Aksi Cepat</h2>

        <div class="grid grid-cols-2 gap-2.5">
            <a href="<?= base_url('admin/layanan/create') ?>" 
               class="group p-3 bg-white border border-slate-200/90 rounded-2xl flex items-center gap-3 hover:border-desentra-teal shadow-[0_2px_8px_-2px_rgba(0,0,0,0.03)] hover:shadow-md hover:shadow-teal-900/5 active:scale-98 transition-all">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-50 to-teal-100/80 text-desentra-teal border border-teal-200/60 flex items-center justify-center font-bold text-base group-hover:bg-desentra-teal group-hover:text-white group-hover:border-desentra-teal transition-all shrink-0">
                    +
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-black text-slate-900 block leading-tight truncate group-hover:text-desentra-teal transition-colors">Tambah Panduan</span>
                    <span class="text-[10px] text-slate-400 block leading-none mt-0.5">Draf layanan baru</span>
                </div>
            </a>

            <a href="<?= base_url('admin/info-desa/create') ?>" 
               class="group p-3 bg-white border border-slate-200/90 rounded-2xl flex items-center gap-3 hover:border-desentra-orange shadow-[0_2px_8px_-2px_rgba(0,0,0,0.03)] hover:shadow-md hover:shadow-orange-900/5 active:scale-98 transition-all">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-orange-50 to-orange-100/80 text-desentra-orange border border-orange-200/60 flex items-center justify-center font-bold text-base group-hover:bg-desentra-orange group-hover:text-white group-hover:border-desentra-orange transition-all shrink-0">
                    +
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-black text-slate-900 block leading-tight truncate group-hover:text-desentra-orange transition-colors">Tambah Info</span>
                    <span class="text-[10px] text-slate-400 block leading-none mt-0.5">Kabar / agenda desa</span>
                </div>
            </a>
        </div>
    </section>

    <!-- 4. PENGADUAN BARU YANG MEMBUTUHKAN TINDAK LANJUT -->
    <?php if (!empty($pendingComplaintsList)): ?>
    <section class="space-y-2">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                <span>Pengaduan Butuh Respon</span>
                <span class="w-2 h-2 rounded-full bg-desentra-orange animate-ping"></span>
            </h2>
            <a href="<?= base_url('admin/pengaduan') ?>" class="text-[11px] font-bold text-desentra-teal hover:underline flex items-center gap-0.5">
                <span>Semua</span>
                <span>→</span>
            </a>
        </div>

        <div class="space-y-2">
            <?php foreach ($pendingComplaintsList as $comp): ?>
            <a href="<?= base_url('admin/pengaduan/detail/' . $comp['id']) ?>" 
               class="block p-3.5 bg-white border border-slate-200/90 rounded-2xl shadow-2xs hover:border-desentra-teal/60 active:scale-99 transition-all">
                <div class="flex items-center justify-between text-[10px] mb-1">
                    <span class="font-mono font-black text-slate-700 bg-slate-100 px-2 py-0.5 rounded"><?= esc($comp['ticket_code']) ?></span>
                    <span class="font-bold uppercase tracking-wide px-2 py-0.5 rounded-full <?= $comp['status'] === 'received' ? 'bg-orange-50 text-desentra-orange border border-orange-200/70' : 'bg-blue-50 text-blue-700 border border-blue-200/70' ?>">
                        <?= $comp['status'] === 'received' ? 'Diterima' : 'Ditelaah' ?>
                    </span>
                </div>
                <h3 class="font-extrabold text-xs text-slate-900 line-clamp-1">
                    <?= esc($comp['title']) ?>
                </h3>
                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                    <?= esc($comp['description']) ?>
                </p>
                <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400 font-medium">
                    <span>Kategori: <strong class="text-slate-600"><?= esc($comp['category']) ?></strong></span>
                    <span><?= date('d M Y, H:i', strtotime($comp['created_at'])) ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- 5. PANDUAN MENUNGGU VERIFIKASI -->
    <?php if (!empty($pendingGuidesList)): ?>
    <section class="space-y-2">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-700">Panduan Menunggu Verifikasi</h2>
            <a href="<?= base_url('admin/layanan') ?>" class="text-[11px] font-bold text-desentra-teal hover:underline flex items-center gap-0.5">
                <span>Semua</span>
                <span>→</span>
            </a>
        </div>

        <div class="space-y-2">
            <?php foreach ($pendingGuidesList as $guide): ?>
            <a href="<?= base_url('admin/layanan/edit/' . $guide['id']) ?>" 
               class="block p-3.5 bg-white border border-amber-200 rounded-2xl shadow-2xs hover:border-amber-400 active:scale-99 transition-all">
                <div class="flex items-center justify-between text-[10px] mb-1">
                    <span class="font-bold text-amber-800 uppercase bg-amber-50 border border-amber-200/80 px-2 py-0.5 rounded-md">
                        ⏳ Perlu Verifikasi
                    </span>
                    <span class="text-slate-400 font-medium"><?= esc($guide['category']) ?></span>
                </div>
                <h3 class="font-extrabold text-xs text-slate-900 line-clamp-1">
                    <?= esc($guide['title']) ?>
                </h3>
                <span class="text-[10px] text-slate-500 block mt-1">
                    Biaya: <strong class="text-slate-700"><?= esc($guide['fee_description']) ?></strong> • Durasi: <strong class="text-slate-700"><?= esc($guide['estimated_duration']) ?></strong>
                </span>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- 6. RIWAYAT AUDIT PETUGAS (Aktivitas Terkini) -->
    <section class="space-y-2">
        <h2 class="text-xs font-black uppercase tracking-wider text-slate-600 px-1">Aktivitas Petugas Terkini</h2>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-3.5 shadow-2xs space-y-2.5">
            <?php if (empty($recentAudits)): ?>
            <p class="text-[11px] text-slate-400 text-center py-2">Belum ada catatan aktivitas audit.</p>
            <?php else: ?>
                <?php foreach ($recentAudits as $audit): ?>
                <?php
                $act = strtoupper($audit['action'] ?? '');
                $actionBadges = [
                    'LOGIN'                 => 'bg-blue-50 text-blue-700 border-blue-200',
                    'LOGOUT'                => 'bg-slate-100 text-slate-600 border-slate-200',
                    'CREATE_GUIDE'          => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'UPDATE_GUIDE'          => 'bg-amber-50 text-amber-700 border-amber-200',
                    'CHANGE_GUIDE_STATUS'   => 'bg-teal-50 text-desentra-teal border-teal-200',
                    'CREATE_INFO'           => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                    'UPDATE_COMPLAINT_STATUS'=> 'bg-orange-50 text-desentra-orange border-orange-200',
                ];
                $badgeStyle = $actionBadges[$act] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                ?>
                <div class="flex items-start justify-between gap-2 text-xs border-b border-slate-100 last:border-none pb-2 last:pb-0">
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="font-bold text-slate-800 text-[11px]">
                                <?= esc($audit['admin_name'] ?? 'Petugas #' . $audit['admin_user_id']) ?>
                            </span>
                            <span class="text-[9px] font-mono font-bold px-1.5 py-0.2 rounded border <?= $badgeStyle ?>">
                                <?= esc($act) ?>
                            </span>
                        </div>
                        <span class="text-[10px] text-slate-400 block mt-0.5 truncate">
                            <?= esc($audit['entity_name']) ?> #<?= esc($audit['entity_id'] ?? '-') ?>
                        </span>
                    </div>
                    <span class="text-[10px] text-slate-400 shrink-0 font-medium">
                        <?= date('d M, H:i', strtotime($audit['created_at'])) ?>
                    </span>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</div>
<?= $this->endSection() ?>
