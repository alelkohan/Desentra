<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 pb-24">

    <!-- Header -->
    <div class="flex items-center justify-between mb-3">
        <div>
            <h1 class="text-lg font-black text-slate-800 tracking-tight">Pengaduan Warga</h1>
            <p class="text-xs text-slate-500 font-medium">Kotak Masuk Tiket & Tindak Lanjut</p>
        </div>
        <span class="text-xs font-bold text-slate-400 bg-white px-2.5 py-1 rounded-xl border border-slate-200">
            <?= $counts['all'] ?> Total
        </span>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="<?= base_url('admin/pengaduan') ?>" class="mb-3">
        <?php if ($currentStatus !== 'all'): ?>
            <input type="hidden" name="status" value="<?= esc($currentStatus) ?>">
        <?php endif; ?>
        <div class="relative">
            <input type="text" name="q" value="<?= esc($search) ?>" placeholder="Cari nomor tiket, judul, atau nomor WA..." 
                   class="w-full pl-9 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-desentra-teal focus:ring-1 focus:ring-desentra-teal shadow-2xs font-medium">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <?php if ($search !== ''): ?>
                <a href="<?= base_url('admin/pengaduan' . ($currentStatus !== 'all' ? '?status=' . $currentStatus : '')) ?>" class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-xs font-bold">✕</a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Filter Pills (Scrollable) -->
    <div class="flex gap-1.5 overflow-x-auto pb-2 mb-3 scrollbar-none text-[11px] font-bold">
        <a href="<?= base_url('admin/pengaduan?status=all' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'all' ? 'bg-slate-800 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Semua (<?= $counts['all'] ?>)
        </a>
        <a href="<?= base_url('admin/pengaduan?status=received' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors flex items-center gap-1 <?= $currentStatus === 'received' ? 'bg-amber-500 text-white shadow-2xs' : 'bg-amber-50 text-amber-800 border border-amber-200' ?>">
            <span>Diterima</span>
            <span class="bg-amber-200/80 text-amber-900 px-1 py-0.2 rounded-full text-[10px]"><?= $counts['received'] ?></span>
        </a>
        <a href="<?= base_url('admin/pengaduan?status=in_review' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'in_review' ? 'bg-blue-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Ditelaah (<?= $counts['in_review'] ?>)
        </a>
        <a href="<?= base_url('admin/pengaduan?status=in_progress' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'in_progress' ? 'bg-desentra-teal text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Diproses (<?= $counts['in_progress'] ?>)
        </a>
        <a href="<?= base_url('admin/pengaduan?status=resolved' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'resolved' ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Selesai (<?= $counts['resolved'] ?>)
        </a>
        <a href="<?= base_url('admin/pengaduan?status=rejected' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'rejected' ? 'bg-rose-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Ditolak (<?= $counts['rejected'] ?>)
        </a>
    </div>

    <!-- Ticket Cards List -->
    <?php if (empty($complaints)): ?>
        <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-2xs mt-2">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                </svg>
            </div>
            <p class="text-xs font-bold text-slate-700">Tidak ada tiket pengaduan</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Semua aduan warga telah ditangani atau belum ada laporan baru.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($complaints as $c): ?>
                <?php
                $statusBadges = [
                    'received'    => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'label' => 'Diterima'],
                    'in_review'   => ['bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'label' => 'Ditelaah'],
                    'in_progress' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-800', 'border' => 'border-teal-200', 'label' => 'Diproses'],
                    'resolved'    => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200', 'label' => 'Selesai'],
                    'rejected'    => ['bg' => 'bg-rose-50', 'text' => 'text-rose-800', 'border' => 'border-rose-200', 'label' => 'Ditolak'],
                ];
                $badge = $statusBadges[$c['status']] ?? $statusBadges['received'];
                ?>
                <a href="<?= base_url('admin/pengaduan/detail/' . $c['id']) ?>" 
                   class="block bg-white rounded-2xl p-3.5 border border-slate-200 shadow-2xs hover:border-desentra-teal/60 active:scale-99 transition-all">
                    
                    <div class="flex items-center justify-between gap-2 mb-1.5">
                        <div class="flex items-center gap-1.5">
                            <span class="font-mono text-[11px] font-extrabold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-md">
                                <?= esc($c['ticket_code']) ?>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">
                                <?= esc($c['category']) ?>
                            </span>
                        </div>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full border <?= $badge['bg'] ?> <?= $badge['text'] ?> <?= $badge['border'] ?>">
                            <?= esc($badge['label']) ?>
                        </span>
                    </div>

                    <h2 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 mb-1.5">
                        <?= esc($c['title']) ?>
                    </h2>

                    <p class="text-[11px] text-slate-500 line-clamp-2 mb-2.5 font-normal">
                        <?= esc($c['description']) ?>
                    </p>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-[10px] text-slate-400 font-medium">
                        <div class="flex items-center gap-1 text-slate-600">
                            <span>📞</span>
                            <span class="font-semibold"><?= esc($c['contact_reply'] ?: 'Anonim') ?></span>
                        </div>
                        <div>
                            <?= date('d M Y, H:i', strtotime($c['created_at'])) ?> WIB
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
