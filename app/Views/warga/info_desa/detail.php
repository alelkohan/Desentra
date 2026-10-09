<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 py-5 space-y-5">

    <!-- Back Button -->
    <div>
        <a href="<?= base_url('info-desa') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-desentra-teal transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali ke Info Desa</span>
        </a>
    </div>

    <!-- Article Content -->
    <article class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm space-y-4">
        
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-[10px]">
                <span class="font-bold text-desentra-orange uppercase tracking-wider bg-orange-50 px-2 py-0.5 rounded-md border border-orange-100">
                    <?= esc($info['category']) ?>
                </span>
                <span class="text-slate-400">
                    Diterbitkan: <?= date('d F Y', strtotime($info['published_at'])) ?>
                </span>
            </div>

            <h1 class="text-lg font-extrabold text-slate-900 leading-snug">
                <?= esc($info['title']) ?>
            </h1>

            <?php if (!empty($info['valid_until'])): ?>
            <div class="inline-flex items-center gap-1.5 text-xs bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 rounded-xl font-medium">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Masa berlaku informasi hingga: <strong><?= date('d F Y', strtotime($info['valid_until'])) ?></strong></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Banner Poster -->
        <?php if (!empty($info['banner_image'])): 
            $detailImg = filter_var($info['banner_image'], FILTER_VALIDATE_URL) 
                ? $info['banner_image'] 
                : base_url(ltrim($info['banner_image'], '/'));
        ?>
        <div class="rounded-2xl overflow-hidden border border-slate-100 bg-slate-100 aspect-[16/9] relative shadow-2xs">
            <img src="<?= esc($detailImg) ?>" 
                 alt="" 
                 class="w-full h-full object-cover"
                 onerror="this.onerror=null; this.src='<?= base_url('img/poster-default.png') ?>';">
        </div>
        <?php endif; ?>

        <div class="border-t border-slate-100 pt-3 text-xs text-slate-700 leading-relaxed space-y-3">
            <?= nl2br(esc($info['content'])) ?>
        </div>

        <!-- Footer Notice -->
        <div class="pt-4 border-t border-slate-100 text-[11px] text-slate-400 flex items-center justify-between">
            <span>Pemerintah Desa Sukamaju</span>
            <span>Desentra Portal Warga</span>
        </div>

    </article>

</div>
<?= $this->endSection() ?>
