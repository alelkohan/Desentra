<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 py-5 space-y-6">

    <!-- Breadcrumb / Back Navigation -->
    <div>
        <a href="<?= base_url('layanan') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-desentra-teal transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali ke Katalog</span>
        </a>
    </div>

    <!-- Title & Verification Status Header -->
    <div class="space-y-2">
        <div class="flex items-center gap-2">
            <span class="text-[10px] font-bold text-desentra-teal bg-desentra-teal/10 px-2 py-0.5 rounded-md">
                <?= esc($guide['category']) ?>
            </span>
            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>Terverifikasi Resmi</span>
            </span>
        </div>

        <h1 class="text-xl font-extrabold tracking-tight text-slate-900 leading-snug">
            <?= esc($guide['title']) ?>
        </h1>
        
        <p class="text-xs text-slate-600 leading-relaxed">
            <?= esc($guide['description'] ?? $guide['summary']) ?>
        </p>
    </div>

    <!-- Quick Info Cards (Biaya & Estimasi Waktu) -->
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-emerald-50/70 border border-emerald-100 rounded-2xl p-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span class="block text-[10px] text-slate-500 font-medium">Biaya Layanan</span>
                <span class="text-xs font-bold text-emerald-700"><?= esc($guide['fee_description']) ?></span>
            </div>
        </div>

        <div class="bg-blue-50/70 border border-blue-100 rounded-2xl p-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-desentra-blue flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span class="block text-[10px] text-slate-500 font-medium">Estimasi Waktu</span>
                <span class="text-xs font-bold text-slate-800"><?= esc($guide['estimated_duration'] ?? '15 Menit') ?></span>
            </div>
        </div>
    </div>

    <!-- Checklist Persyaratan Berkas (Interactive localStorage) -->
    <section class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm space-y-4" id="checklist-section">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-sm text-slate-900 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-desentra-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span>Checklist Persyaratan</span>
                </h2>
                <p class="text-[11px] text-slate-500">Centang dokumen yang sudah Anda siapkan.</p>
            </div>
            <button onclick="resetChecklist()" class="text-[11px] font-semibold text-slate-400 hover:text-red-500 transition-colors">
                Reset
            </button>
        </div>

        <!-- Progress Bar Indicator -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between text-[11px]">
                <span class="text-slate-600 font-medium" id="progress-text">0 dari <?= count($guide['requirements']) ?> syarat siap</span>
                <span class="font-bold text-desentra-teal" id="progress-percent">0%</span>
            </div>
            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                <div id="progress-bar" class="h-full bg-gradient-desentra transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>

        <!-- Requirements Items -->
        <div class="space-y-2.5 pt-1">
            <?php foreach ($guide['requirements'] as $req): ?>
            <label class="flex items-start gap-3 p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50/80 cursor-pointer transition-all req-item">
                <input type="checkbox" 
                       data-req-id="<?= esc($req['id']) ?>" 
                       onchange="toggleReq(this)" 
                       class="mt-0.5 w-4 h-4 text-desentra-teal rounded border-slate-300 focus:ring-desentra-teal">
                <div class="space-y-0.5 flex-1">
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-semibold text-slate-800 req-title"><?= esc($req['title']) ?></span>
                        <?php if ($req['is_mandatory']): ?>
                            <span class="text-[9px] font-bold text-red-500 bg-red-50 px-1 rounded">Wajib</span>
                        <?php else: ?>
                            <span class="text-[9px] font-medium text-slate-400 bg-slate-100 px-1 rounded">Opsional</span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($req['description'])): ?>
                    <p class="text-[11px] text-slate-500"><?= esc($req['description']) ?></p>
                    <?php endif; ?>
                </div>
            </label>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Alur & Langkah Prosedur -->
    <section class="space-y-3">
        <h2 class="font-bold text-sm text-slate-900 flex items-center gap-1.5">
            <svg class="w-4 h-4 text-desentra-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
            <span>Alur Pelayanan di Kantor Desa</span>
        </h2>

        <div class="space-y-3 pl-2 border-l-2 border-desentra-teal/30 ml-2">
            <?php foreach ($steps as $idx => $step): ?>
            <div class="relative pl-5">
                <div class="absolute -left-[17px] top-0 w-6 h-6 rounded-full bg-desentra-teal text-white text-[11px] font-bold flex items-center justify-center shadow-sm">
                    <?= $idx + 1 ?>
                </div>
                <div class="bg-white border border-slate-200/80 rounded-xl p-3 shadow-sm">
                    <p class="text-xs text-slate-700 font-medium leading-relaxed">
                        <?= esc($step) ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Tanya Jawab (FAQ Terkait) -->
    <?php if (!empty($guide['faqs'])): ?>
    <section class="space-y-3">
        <h2 class="font-bold text-sm text-slate-900">Pertanyaan Sering Diajukan (FAQ)</h2>
        <div class="space-y-2">
            <?php foreach ($guide['faqs'] as $faq): ?>
            <details class="group bg-white border border-slate-200 rounded-xl p-3 text-xs">
                <summary class="font-bold text-slate-800 cursor-pointer flex items-center justify-between list-none">
                    <span><?= esc($faq['question']) ?></span>
                    <svg class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7"></path>
                    </svg>
                </summary>
                <p class="mt-2 text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                    <?= esc($faq['answer']) ?>
                </p>
            </details>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Rujukan Sumber & Tanggal Verifikasi (Transparansi Prinsip PRD) -->
    <section class="bg-slate-100/80 rounded-2xl p-4 space-y-2 border border-slate-200">
        <div class="flex items-center gap-1.5 text-xs font-bold text-slate-700">
            <svg class="w-4 h-4 text-desentra-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span>Sumber & Legalitas Panduan</span>
        </div>
        <p class="text-[11px] text-slate-500">
            Terakhir ditinjau pada: <strong class="text-slate-700"><?= $guide['checked_at'] ? date('d F Y', strtotime($guide['checked_at'])) : date('d F Y') ?></strong> oleh Petugas Verifikator Desa Sukamaju.
        </p>

        <?php if (!empty($guide['sources'])): ?>
        <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside pt-1">
            <?php foreach ($guide['sources'] as $src): ?>
            <li>
                <strong><?= esc($src['title']) ?></strong> (<?= esc($src['publisher']) ?>)
                <?php if (!empty($src['citation_note'])): ?>
                    - <em><?= esc($src['citation_note']) ?></em>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </section>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const guideId = <?= (int)$guide['id'] ?>;
    const storageKey = `desentra_checklist_${guideId}`;
    const totalRequirements = <?= count($guide['requirements']) ?>;

    function getSavedChecklist() {
        try {
            return JSON.parse(localStorage.getItem(storageKey) || '{}');
        } catch (e) {
            return {};
        }
    }

    function saveChecklist(data) {
        localStorage.setItem(storageKey, JSON.stringify(data));
        updateProgress();
    }

    function toggleReq(checkbox) {
        const reqId = checkbox.dataset.reqId;
        const saved = getSavedChecklist();
        saved[reqId] = checkbox.checked;
        saveChecklist(saved);
    }

    function resetChecklist() {
        window.showConfirmBottomSheet({
            title: 'Reset Checklist Persyaratan?',
            message: 'Centang seluruh dokumen yang telah Anda siapkan pada panduan ini akan dikosongkan kembali.',
            type: 'warning',
            confirmText: 'Ya, Reset',
            cancelText: 'Batal',
            onConfirm: function() {
                localStorage.removeItem(storageKey);
                document.querySelectorAll('#checklist-section input[type="checkbox"]').forEach(cb => cb.checked = false);
                updateProgress();
            }
        });
    }

    function updateProgress() {
        const saved = getSavedChecklist();
        const checkboxes = document.querySelectorAll('#checklist-section input[type="checkbox"]');
        let checkedCount = 0;

        checkboxes.forEach(cb => {
            const reqId = cb.dataset.reqId;
            if (saved[reqId]) {
                cb.checked = true;
                checkedCount++;
            } else {
                cb.checked = false;
            }
        });

        const percent = totalRequirements > 0 ? Math.round((checkedCount / totalRequirements) * 100) : 0;
        document.getElementById('progress-text').innerText = `${checkedCount} dari ${totalRequirements} syarat siap`;
        document.getElementById('progress-percent').innerText = `${percent}%`;
        document.getElementById('progress-bar').style.width = `${percent}%`;
    }

    // Init on load
    document.addEventListener('DOMContentLoaded', updateProgress);
</script>
<?= $this->endSection() ?>
