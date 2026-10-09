<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 pb-24">

    <!-- Header & Action -->
    <div class="flex items-center justify-between mb-3">
        <div>
            <h1 class="text-lg font-black text-slate-800 tracking-tight">Info & Pengumuman</h1>
            <p class="text-xs text-slate-500 font-medium">Publikasi Kabar & Agenda Desa</p>
        </div>
        <a href="<?= base_url('admin/info-desa/create') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 bg-desentra-teal text-white rounded-xl text-xs font-bold shadow-md shadow-teal-900/10 hover:bg-teal-700 active:scale-95 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah</span>
        </a>
    </div>

    <!-- Category Filters (Scrollable) -->
    <div class="flex gap-1.5 overflow-x-auto pb-2 mb-3 scrollbar-none text-[11px] font-bold">
        <a href="<?= base_url('admin/info-desa?category=all') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentCategory === 'all' ? 'bg-slate-800 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Semua (<?= $counts['all'] ?>)
        </a>
        <a href="<?= base_url('admin/info-desa?category=announcement') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentCategory === 'announcement' ? 'bg-desentra-teal text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Pengumuman (<?= $counts['announcement'] ?>)
        </a>
        <a href="<?= base_url('admin/info-desa?category=schedule') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentCategory === 'schedule' ? 'bg-desentra-teal text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Jadwal (<?= $counts['schedule'] ?>)
        </a>
        <a href="<?= base_url('admin/info-desa?category=agenda') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentCategory === 'agenda' ? 'bg-desentra-teal text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Agenda (<?= $counts['agenda'] ?>)
        </a>
        <a href="<?= base_url('admin/info-desa?category=important') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentCategory === 'important' ? 'bg-rose-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Penting (<?= $counts['important'] ?>)
        </a>
    </div>

    <!-- Info Cards List -->
    <?php if (empty($infos)): ?>
        <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-2xs mt-2">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
            </div>
            <p class="text-xs font-bold text-slate-700">Belum ada info desa</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Mulai publikasikan agenda kegiatan atau pengumuman desa.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($infos as $info): ?>
                <?php
                $isExpired = false;
                if (!empty($info['valid_until'])) {
                    $isExpired = (strtotime($info['valid_until']) < strtotime(date('Y-m-d')));
                }
                $imgSrc = base_url('img/' . ($info['banner_image'] ?? 'poster-default.png'));
                ?>
                <div class="bg-white rounded-2xl p-3 border border-slate-200 shadow-2xs flex gap-3 hover:border-slate-300 transition-all">
                    <!-- Poster Thumbnail -->
                    <div class="w-20 h-24 rounded-xl overflow-hidden bg-slate-100 shrink-0 relative border border-slate-200">
                        <img src="<?= $imgSrc ?>" alt="<?= esc($info['title']) ?>" class="w-full h-full object-cover">
                    </div>

                    <!-- Details -->
                    <div class="flex-1 flex flex-col justify-between min-w-0">
                        <div>
                            <div class="flex items-center justify-between gap-1 mb-1">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-desentra-teal bg-teal-50 px-1.5 py-0.5 rounded">
                                    <?= esc($info['category']) ?>
                                </span>
                                <?php if ($isExpired): ?>
                                    <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200">
                                        Kedaluwarsa
                                    </span>
                                <?php elseif ($info['status'] === 'published'): ?>
                                    <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-slate-100 text-slate-600">
                                        Draf
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h2 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 mb-1">
                                <?= esc($info['title']) ?>
                            </h2>

                            <?php if (!empty($info['valid_until'])): ?>
                                <p class="text-[10px] text-slate-400 flex items-center gap-1 font-medium">
                                    <span>🗓 Berlaku s.d:</span>
                                    <span class="font-bold text-slate-600"><?= date('d M Y', strtotime($info['valid_until'])) ?></span>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <a href="<?= base_url('admin/info-desa/edit/' . $info['id']) ?>" 
                                   class="text-[11px] font-bold text-desentra-teal hover:underline">
                                    Edit
                                </a>
                                <a href="<?= base_url('info-desa/detail/' . $info['slug']) ?>" target="_blank"
                                   class="text-[11px] font-medium text-slate-400 hover:text-slate-600">
                                    Lihat
                                </a>
                            </div>

                            <form method="POST" action="<?= base_url('admin/info-desa/delete/' . $info['id']) ?>" 
                                  data-confirm="Info desa ini akan dihapus permanen dari sistem dan tidak tampil lagi di beranda warga." 
                                  data-confirm-title="Hapus Info Desa?" 
                                  data-confirm-type="danger" 
                                  data-confirm-btn="Ya, Hapus">
                                <button type="submit" class="text-slate-300 hover:text-rose-600 p-1 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
