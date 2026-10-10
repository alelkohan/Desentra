<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10 space-y-6 pb-28 md:pb-16">

    <!-- Breadcrumb / Back Navigation -->
    <div>
        <a href="<?= base_url('layanan') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-desentra-teal transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali ke Katalog Layanan</span>
        </a>
    </div>

    <!-- Responsive Layout: 1 Column on Mobile, 12-Column Grid on Desktop -->
    <div class="lg:grid lg:grid-cols-12 lg:gap-8 space-y-6 lg:space-y-0">
        
        <!-- Left / Main Column (col-span-8) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Title & Verification Status Header -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-6 shadow-xs space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] md:text-xs font-bold text-desentra-teal bg-desentra-teal/10 px-2.5 py-1 rounded-md">
                        <?= esc($guide['category']) ?>
                    </span>
                    <span class="inline-flex items-center gap-1 text-[10px] md:text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-md">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Terverifikasi Resmi</span>
                    </span>
                </div>

                <h1 class="text-xl md:text-2xl lg:text-3xl font-extrabold tracking-tight text-slate-900 leading-snug">
                    <?= esc($guide['title']) ?>
                </h1>
                
                <p class="text-xs md:text-sm text-slate-600 leading-relaxed">
                    <?= esc($guide['description'] ?? $guide['summary']) ?>
                </p>
            </div>

            <!-- Quick Info Cards on Mobile (Hidden on Desktop because shown in Sidebar) -->
            <div class="grid grid-cols-2 gap-3 lg:hidden">
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
            <section class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-6 shadow-xs space-y-4" id="checklist-section">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-extrabold text-sm md:text-base text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-desentra-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span>Checklist Persyaratan Berkas</span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Centang dokumen yang sudah Anda siapkan. Data checklist tersimpan otomatis di perangkat Anda.</p>
                    </div>
                    <button onclick="resetChecklist()" class="text-xs font-semibold text-slate-400 hover:text-rose-600 transition-colors px-2 py-1 rounded-lg hover:bg-rose-50">
                        Reset
                    </button>
                </div>

                <!-- Progress Bar Indicator -->
                <div class="space-y-1.5 bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-600 font-medium" id="progress-text">0 dari <?= count($guide['requirements']) ?> syarat siap</span>
                        <span class="font-bold text-desentra-teal" id="progress-percent">0%</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-200/70 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-desentra-teal to-desentra-turquoise transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Requirements Items -->
                <div class="space-y-2.5 pt-1">
                    <?php foreach ($guide['requirements'] as $req): ?>
                    <label class="flex items-start gap-3.5 p-3 md:p-3.5 rounded-2xl border border-slate-100 hover:border-desentra-teal/30 hover:bg-slate-50/80 cursor-pointer transition-all req-item">
                        <input type="checkbox" 
                               data-req-id="<?= esc($req['id']) ?>" 
                               onchange="toggleReq(this)" 
                               class="mt-0.5 w-4.5 h-4.5 text-desentra-teal rounded-lg border-slate-300 focus:ring-desentra-teal">
                        <div class="space-y-0.5 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs md:text-sm font-bold text-slate-800 req-title"><?= esc($req['title']) ?></span>
                                <?php if ($req['is_mandatory']): ?>
                                    <span class="text-[9px] md:text-[10px] font-bold text-rose-600 bg-rose-50 border border-rose-200 px-1.5 py-0.5 rounded-md">Wajib</span>
                                <?php else: ?>
                                    <span class="text-[9px] md:text-[10px] font-medium text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded-md">Opsional</span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($req['description'])): ?>
                            <p class="text-xs text-slate-500 leading-relaxed"><?= esc($req['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Alur & Langkah Prosedur -->
            <section class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-6 shadow-xs space-y-4">
                <h2 class="font-extrabold text-sm md:text-base text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-desentra-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                    <span>Alur Pelayanan di Kantor Desa</span>
                </h2>

                <div class="space-y-3 pl-2 border-l-2 border-desentra-teal/30 ml-2">
                    <?php foreach ($steps as $idx => $step): ?>
                    <div class="relative pl-6">
                        <div class="absolute -left-[19px] top-0 w-7 h-7 rounded-full bg-desentra-teal text-white text-xs font-bold flex items-center justify-center shadow-xs">
                            <?= $idx + 1 ?>
                        </div>
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5 shadow-2xs">
                            <p class="text-xs md:text-sm text-slate-700 font-medium leading-relaxed">
                                <?= esc($step) ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Tanya Jawab (FAQ Terkait) -->
            <?php if (!empty($guide['faqs'])): ?>
            <section class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-6 shadow-xs space-y-3">
                <h2 class="font-extrabold text-sm md:text-base text-slate-900">Pertanyaan Sering Diajukan (FAQ)</h2>
                <div class="space-y-2.5">
                    <?php foreach ($guide['faqs'] as $faq): ?>
                    <details class="group bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5 text-xs md:text-sm">
                        <summary class="font-bold text-slate-800 cursor-pointer flex items-center justify-between list-none">
                            <span><?= esc($faq['question']) ?></span>
                            <svg class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7"></path>
                            </svg>
                        </summary>
                        <p class="mt-2 text-slate-600 leading-relaxed pt-2 border-t border-slate-200/70">
                            <?= esc($faq['answer']) ?>
                        </p>
                    </details>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

        </div>

        <!-- Right / Sidebar Column (col-span-4, Sticky on Desktop) -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24 lg:self-start">
            
            <!-- Quick Info Desktop Card (Biaya & Waktu) -->
            <div class="hidden lg:grid grid-cols-2 gap-3.5">
                <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-4 flex flex-col justify-between">
                    <div class="w-9 h-9 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-3">
                        <span class="block text-[10px] text-slate-500 font-medium">Biaya Layanan</span>
                        <span class="text-sm font-extrabold text-emerald-700"><?= esc($guide['fee_description']) ?></span>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-3xl p-4 flex flex-col justify-between">
                    <div class="w-9 h-9 rounded-2xl bg-blue-500/10 text-desentra-blue flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-3">
                        <span class="block text-[10px] text-slate-500 font-medium">Estimasi Waktu</span>
                        <span class="text-sm font-extrabold text-slate-800"><?= esc($guide['estimated_duration'] ?? '15 Menit') ?></span>
                    </div>
                </div>
            </div>

            <!-- Bantuan AI Assistant Box -->
            <div class="bg-gradient-to-br from-desentra-teal to-[#009E94] rounded-3xl p-5 text-white shadow-md shadow-desentra-teal/20 space-y-3">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-bold">
                    <span>✦ Asisten Panduan AI</span>
                </div>
                <h3 class="font-extrabold text-base leading-snug">Ada Pertanyaan Mengenai Syarat Ini?</h3>
                <p class="text-xs text-white/90 leading-relaxed">
                    Tanyakan langsung persyaratan khusus atau alur alternatif ke Desentra AI.
                </p>
                <a href="<?= base_url('tanya') ?>" class="inline-flex items-center justify-center w-full py-2.5 rounded-2xl bg-white text-desentra-teal font-extrabold text-xs hover:bg-orange-50 hover:text-desentra-orange transition-all shadow-xs">
                    Konsultasi AI Sekarang →
                </a>
            </div>

            <!-- Rujukan Sumber & Tanggal Verifikasi -->
            <section class="bg-white rounded-3xl p-5 space-y-3 border border-slate-200/90 shadow-xs">
                <div class="flex items-center gap-2 text-xs font-extrabold text-slate-800">
                    <svg class="w-4 h-4 text-desentra-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>Legalitas & Sumber Panduan</span>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Terakhir ditinjau: <strong class="text-slate-700"><?= $guide['checked_at'] ? date('d F Y', strtotime($guide['checked_at'])) : date('d F Y') ?></strong> oleh Petugas Verifikator Desa.
                </p>

                <?php if (!empty($guide['sources'])): ?>
                <ul class="text-xs text-slate-600 space-y-1.5 list-disc list-inside pt-1">
                    <?php foreach ($guide['sources'] as $src): ?>
                    <li>
                        <strong><?= esc($src['title']) ?></strong> (<?= esc($src['publisher']) ?>)
                        <?php if (!empty($src['citation_note'])): ?>
                            <br><span class="text-slate-400 pl-4 italic text-[11px]"><?= esc($src['citation_note']) ?></span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </section>

        </div>

    </div>

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

    document.addEventListener('DOMContentLoaded', updateProgress);
</script>
<?= $this->endSection() ?>
