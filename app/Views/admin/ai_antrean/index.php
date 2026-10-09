<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 pb-24">

    <!-- Header -->
    <div class="flex items-center justify-between mb-3">
        <div>
            <h1 class="text-lg font-black text-slate-800 tracking-tight">Antrean Tanya AI</h1>
            <p class="text-xs text-slate-500 font-medium">Review Pertanyaan Warga & Celah RAG</p>
        </div>
        <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-xl border border-amber-200">
            <?= $counts['pending'] ?> Perlu Telaah
        </span>
    </div>

    <!-- Explanatory Notice -->
    <div class="mb-3 p-3 bg-teal-50/70 border border-teal-100 rounded-2xl flex items-start gap-2.5 shadow-2xs">
        <span class="text-base shrink-0">💡</span>
        <p class="text-[11px] text-teal-900 leading-relaxed font-medium">
            Pertanyaan warga di bawah ini memicu <em>fallback</em> karena belum ada panduan resmi di sistem. Klik <strong>"Jadikan Draf Panduan"</strong> untuk langsung membuat basis pengetahuan baru.
        </p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-1.5 overflow-x-auto pb-2 mb-3 scrollbar-none text-[11px] font-bold">
        <a href="<?= base_url('admin/ai-antrean?tab=pending') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors flex items-center gap-1 <?= $currentTab === 'pending' ? 'bg-amber-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            <span>Perlu Tindak Lanjut</span>
            <span class="bg-amber-200/80 text-amber-900 px-1 py-0.2 rounded-full text-[10px]"><?= $counts['pending'] ?></span>
        </a>
        <a href="<?= base_url('admin/ai-antrean?tab=all') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentTab === 'all' ? 'bg-slate-800 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Semua Interaksi (<?= $counts['all'] ?>)
        </a>
        <a href="<?= base_url('admin/ai-antrean?tab=resolved') ?>" 
           class="px-2.5 py-1.5 rounded-lg whitespace-nowrap transition-colors <?= $currentTab === 'resolved' ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200' ?>">
            Diselesaikan (<?= $counts['resolved'] ?>)
        </a>
    </div>

    <!-- Questions List -->
    <?php if (empty($questions)): ?>
        <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-2xs mt-2">
            <div class="w-12 h-12 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-xs font-bold text-slate-700">Antrean Pertanyaan Bersih</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada pertanyaan warga yang belum tertangani saat ini.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($questions as $q): ?>
                <div class="bg-white rounded-2xl p-3.5 border border-slate-200 shadow-2xs space-y-2.5 hover:border-slate-300 transition-all">
                    
                    <!-- Top meta -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5">
                            <?php if ($q['is_fallback']): ?>
                                <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                                    Fallback RAG
                                </span>
                            <?php else: ?>
                                <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    Terjawab Otomatis
                                </span>
                            <?php endif; ?>

                            <?php if ($q['status'] === 'resolved'): ?>
                                <span class="text-[9px] font-bold uppercase px-1.5 py-0.5 rounded bg-slate-100 text-slate-500">
                                    Selesai
                                </span>
                            <?php endif; ?>
                        </div>

                        <span class="text-[10px] text-slate-400">
                            <?= date('d M, H:i', strtotime($q['created_at'])) ?> WIB
                        </span>
                    </div>

                    <!-- Question Text -->
                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                        <span class="text-[9px] font-bold uppercase text-slate-400 block mb-0.5">Pertanyaan Warga:</span>
                        <p class="text-xs font-bold text-slate-900 leading-snug">
                            "<?= esc($q['question_text']) ?>"
                        </p>
                    </div>

                    <!-- Answer Preview -->
                    <?php if (!empty($q['answer_text'])): ?>
                        <div class="text-[11px] text-slate-500 leading-relaxed font-normal line-clamp-2 pl-2 border-l-2 border-slate-200">
                            <span class="font-semibold text-slate-700">Respon AI:</span> <?= esc($q['answer_text']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                        <!-- Shortcut: Jadikan Draf Panduan -->
                        <a href="<?= base_url('admin/layanan/create?from_q=' . $q['id'] . '&title=' . urlencode($q['question_text'])) ?>" 
                           class="flex-1 py-1.5 px-2.5 bg-desentra-teal hover:bg-teal-700 text-white rounded-lg text-xs font-bold text-center flex items-center justify-center gap-1 shadow-xs active:scale-98 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Jadikan Draf Panduan</span>
                        </a>

                        <?php if ($q['status'] !== 'resolved'): ?>
                            <form method="POST" action="<?= base_url('admin/ai-antrean/resolve/' . $q['id']) ?>"
                                  data-confirm="Pertanyaan ini akan ditandai selesai dan diarsipkan dari antrean peninjauan." 
                                  data-confirm-title="Tandai Selesai?" 
                                  data-confirm-type="success" 
                                  data-confirm-btn="Ya, Tandai Selesai">
                                <button type="submit" class="py-1.5 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors">
                                    Tandai Selesai
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
