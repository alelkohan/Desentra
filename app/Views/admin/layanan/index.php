<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 pb-24">

    <!-- Page Header & Action -->
    <div class="flex items-center justify-between mb-3">
        <div>
            <h1 class="text-lg font-black text-slate-800 tracking-tight">Panduan Layanan</h1>
            <p class="text-xs text-slate-500 font-medium">Basis Pengetahuan & RAG AI Desa</p>
        </div>
        <a href="<?= base_url('admin/layanan/create') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 bg-desentra-teal text-white rounded-xl text-xs font-bold shadow-md shadow-teal-900/10 hover:bg-teal-700 active:scale-95 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah</span>
        </a>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="<?= base_url('admin/layanan') ?>" class="mb-3">
        <?php if ($currentStatus !== 'all'): ?>
            <input type="hidden" name="status" value="<?= esc($currentStatus) ?>">
        <?php endif; ?>
        <div class="relative">
            <input type="text" name="q" value="<?= esc($search) ?>" placeholder="Cari judul panduan atau kategori..." 
                   class="w-full pl-9 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-desentra-teal focus:ring-1 focus:ring-desentra-teal shadow-2xs font-medium">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <?php if ($search !== ''): ?>
                <a href="<?= base_url('admin/layanan' . ($currentStatus !== 'all' ? '?status=' . $currentStatus : '')) ?>" class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-xs font-bold">✕</a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Filter Pills (Scrollable) -->
    <div class="flex gap-1.5 overflow-x-auto pb-2 mb-3 scrollbar-none text-[11px] font-bold">
        <a href="<?= base_url('admin/layanan?status=all' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'all' ? 'bg-slate-800 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">
            Semua (<?= $counts['all'] ?>)
        </a>
        <a href="<?= base_url('admin/layanan?status=pending_verification' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors flex items-center gap-1 <?= $currentStatus === 'pending_verification' ? 'bg-amber-600 text-white shadow-2xs' : 'bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100' ?>">
            <span>Perlu Verifikasi</span>
            <span class="bg-amber-200/80 text-amber-900 px-1 py-0.2 rounded-full text-[10px]"><?= $counts['pending_verification'] ?></span>
        </a>
        <a href="<?= base_url('admin/layanan?status=published' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'published' ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">
            Diterbitkan (<?= $counts['published'] ?>)
        </a>
        <a href="<?= base_url('admin/layanan?status=draft' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'draft' ? 'bg-slate-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">
            Draf (<?= $counts['draft'] ?>)
        </a>
        <a href="<?= base_url('admin/layanan?status=needs_review' . ($search ? '&q=' . urlencode($search) : '')) ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentStatus === 'needs_review' ? 'bg-rose-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">
            Revisi (<?= $counts['needs_review'] ?>)
        </a>
    </div>

    <!-- Guides List -->
    <?php if (empty($guides)): ?>
        <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-2xs mt-2">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <p class="text-xs font-bold text-slate-700">Tidak ada panduan layanan</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Silakan sesuaikan filter atau tambahkan panduan baru.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($guides as $g): ?>
                <?php
                $statusBadges = [
                    'published'            => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Terbit / Aktif RAG'],
                    'pending_verification' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'Menunggu Verifikasi'],
                    'draft'                => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'label' => 'Draf'],
                    'needs_review'         => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'label' => 'Perlu Revisi'],
                    'archived'             => ['bg' => 'bg-slate-100', 'text' => 'text-slate-400', 'border' => 'border-slate-200', 'label' => 'Diarsipkan'],
                ];
                $badge = $statusBadges[$g['status']] ?? $statusBadges['draft'];
                ?>
                <div class="bg-white rounded-2xl p-3.5 border border-slate-200 shadow-2xs hover:border-slate-300 transition-all flex flex-col justify-between">
                    <div>
                        <!-- Header Card: Category & Status -->
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="text-[10px] font-bold text-desentra-teal uppercase tracking-wider bg-teal-50 px-2 py-0.5 rounded">
                                <?= esc($g['category']) ?>
                            </span>
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full border <?= $badge['bg'] ?> <?= $badge['text'] ?> <?= $badge['border'] ?>">
                                <?= esc($badge['label']) ?>
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-sm font-bold text-slate-900 leading-snug mb-1">
                            <?= esc($g['title']) ?>
                        </h2>

                        <!-- Summary -->
                        <p class="text-xs text-slate-500 line-clamp-2 mb-2 font-normal">
                            <?= esc($g['summary']) ?>
                        </p>

                        <!-- Meta Pill: Biaya & Durasi -->
                        <div class="flex items-center gap-3 text-[11px] text-slate-500 mb-3 bg-slate-50/70 px-2.5 py-1.5 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-1 font-semibold text-slate-700">
                                <span class="text-emerald-600">💰</span>
                                <span><?= esc($g['fee_description'] ?? 'Gratis') ?></span>
                            </div>
                            <span class="text-slate-300">•</span>
                            <div class="flex items-center gap-1 font-semibold text-slate-700">
                                <span>⏱</span>
                                <span><?= esc($g['estimated_duration'] ?? '1 hari') ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Bar -->
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5">
                            <a href="<?= base_url('admin/layanan/edit/' . $g['id']) ?>" 
                               class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors">
                                Edit Form
                            </a>
                            <a href="<?= base_url('layanan/detail/' . $g['slug']) ?>" target="_blank"
                               class="px-2 py-1.5 text-slate-400 hover:text-desentra-teal text-xs transition-colors" title="Lihat Tampilan Warga">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Quick Workflow Actions -->
                        <div class="flex items-center gap-1.5">
                            <?php if (($userRole === 'verifier' || $userRole === 'admin') && $g['status'] !== 'published'): ?>
                                <form method="POST" action="<?= base_url('admin/layanan/status/' . $g['id']) ?>" 
                                      data-confirm="Panduan ini akan langsung tampil di portal warga dan otomatis diindeks ke AI." 
                                      data-confirm-title="Terbitkan Panduan Layanan?" 
                                      data-confirm-type="success" 
                                      data-confirm-btn="Ya, Terbitkan">
                                    <input type="hidden" name="status" value="published">
                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 active:scale-95 transition-all flex items-center gap-1">
                                        <span>✓ Terbitkan</span>
                                    </button>
                                </form>
                            <?php elseif ($userRole === 'editor' && $g['status'] === 'draft'): ?>
                                <form method="POST" action="<?= base_url('admin/layanan/status/' . $g['id']) ?>" 
                                      data-confirm="Panduan akan dikirim ke akun Verifikator untuk peninjauan regulasi." 
                                      data-confirm-title="Ajukan Verifikasi?" 
                                      data-confirm-type="info" 
                                      data-confirm-btn="Ya, Ajukan">
                                    <input type="hidden" name="status" value="pending_verification">
                                    <button type="submit" class="px-2.5 py-1.5 bg-amber-500 text-white rounded-lg text-xs font-bold hover:bg-amber-600 active:scale-95 transition-all">
                                        Ajukan Review
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($userRole === 'admin'): ?>
                                <form method="POST" action="<?= base_url('admin/layanan/delete/' . $g['id']) ?>" 
                                      data-confirm="Panduan beserta seluruh persyaratannya akan dihapus permanen dari sistem." 
                                      data-confirm-title="Hapus Panduan Layanan?" 
                                      data-confirm-type="danger" 
                                      data-confirm-btn="Ya, Hapus Permanen">
                                    <button type="submit" class="p-1.5 text-slate-300 hover:text-rose-600 rounded-lg transition-colors" title="Hapus Panduan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
