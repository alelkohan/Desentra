<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 pb-28">

    <!-- Header & Back Button -->
    <div class="flex items-center gap-2 mb-4">
        <a href="<?= base_url('admin/layanan') ?>" class="p-2 -ml-2 text-slate-500 hover:text-slate-800 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-base font-black text-slate-900 tracking-tight">
                <?= $guide ? 'Edit Panduan Layanan' : 'Buat Panduan Layanan Baru' ?>
            </h1>
            <p class="text-[11px] text-slate-500 font-medium">Lengkapi parameter informasi & pengetahuan RAG</p>
        </div>
    </div>

    <form method="POST" action="<?= $guide ? base_url('admin/layanan/update/' . $guide['id']) : base_url('admin/layanan/store') ?>" id="guideForm" class="space-y-4">
        
        <?php if (!empty($fromQuestionId)): ?>
            <input type="hidden" name="from_question_id" value="<?= (int) $fromQuestionId ?>">
            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 font-medium">
                💡 Panduan ini dibuat untuk menjawab antrean pertanyaan warga yang belum terjawab oleh AI.
            </div>
        <?php endif; ?>

        <!-- SECTION 1: Informasi Dasar -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3.5">
            <h2 class="text-xs font-black uppercase tracking-wider text-desentra-teal border-b border-slate-100 pb-2">
                1. Informasi Pokok
            </h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Layanan <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required value="<?= esc(old('title', $guide['title'] ?? $prefillTitle)) ?>" 
                       placeholder="Contoh: Surat Pengantar SKCK" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-desentra-teal focus:bg-white focus:ring-1 focus:ring-desentra-teal">
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                    <select name="category" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white">
                        <?php
                        $cats = ['Kependudukan', 'Perizinan', 'Pertanahan', 'Sosial', 'Umum'];
                        $curCat = old('category', $guide['category'] ?? 'Kependudukan');
                        foreach ($cats as $c):
                        ?>
                            <option value="<?= $c ?>" <?= $curCat === $c ? 'selected' : '' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Biaya Retribusi</label>
                    <input type="text" name="fee_description" value="<?= esc(old('fee_description', $guide['fee_description'] ?? 'Gratis (Rp 0)')) ?>" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Estimasi Waktu Pelayanan</label>
                <input type="text" name="estimated_duration" value="<?= esc(old('estimated_duration', $guide['estimated_duration'] ?? '1 Hari Kerja')) ?>" 
                       placeholder="Contoh: 1 Hari Kerja / Langsung Jadi"
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Singkat <span class="text-rose-500">*</span></label>
                <textarea name="summary" rows="2" required placeholder="Ringkasan 1-2 kalimat untuk kartu & prompt RAG..." 
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white"><?= esc(old('summary', $guide['summary'] ?? '')) ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Penjelasan Detail (Opsional)</label>
                <textarea name="description" rows="3" placeholder="Informasi tambahan, dasar hukum, atau pengecualian..." 
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white"><?= esc(old('description', $guide['description'] ?? '')) ?></textarea>
            </div>
        </div>

        <!-- SECTION 2: Syarat Dokumen (Checklist Warga) -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <h2 class="text-xs font-black uppercase tracking-wider text-desentra-teal">
                    2. Persyaratan Berkas
                </h2>
                <button type="button" onclick="addRequirementRow()" class="text-[11px] font-bold text-desentra-teal hover:underline flex items-center gap-1">
                    + Tambah Berkas
                </button>
            </div>
            
            <p class="text-[11px] text-slate-500">Daftar berkas yang wajib atau opsional dibawa warga ke kantor desa.</p>

            <div id="requirementsContainer" class="space-y-2">
                <?php if (!empty($requirements)): ?>
                    <?php foreach ($requirements as $i => $req): ?>
                        <div class="req-row p-2.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 relative">
                            <div class="flex items-center gap-2">
                                <input type="text" name="req_titles[]" value="<?= esc($req['title']) ?>" placeholder="Nama berkas (mis: KTP Asli / FC KK)" required
                                       class="flex-1 px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-desentra-teal">
                                <label class="flex items-center gap-1 text-[11px] font-bold text-slate-700 whitespace-nowrap cursor-pointer">
                                    <input type="checkbox" name="req_mandatory[<?= $i ?>]" value="1" <?= $req['is_mandatory'] ? 'checked' : '' ?> class="rounded text-desentra-teal focus:ring-0">
                                    <span>Wajib</span>
                                </label>
                                <button type="button" onclick="this.closest('.req-row').remove()" class="text-slate-400 hover:text-rose-600 p-1">✕</button>
                            </div>
                            <input type="text" name="req_descriptions[]" value="<?= esc($req['description'] ?? '') ?>" placeholder="Catatan tambahan (mis: 1 lembar, legalisir bila luar daerah)"
                                   class="w-full px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[11px] text-slate-600 focus:outline-none focus:border-desentra-teal">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="req-row p-2.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 relative">
                        <div class="flex items-center gap-2">
                            <input type="text" name="req_titles[]" value="Kartu Tanda Penduduk (KTP) Asli & Fotokopi" placeholder="Nama berkas" required
                                   class="flex-1 px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-desentra-teal">
                            <label class="flex items-center gap-1 text-[11px] font-bold text-slate-700 whitespace-nowrap cursor-pointer">
                                <input type="checkbox" name="req_mandatory[0]" value="1" checked class="rounded text-desentra-teal focus:ring-0">
                                <span>Wajib</span>
                            </label>
                            <button type="button" onclick="this.closest('.req-row').remove()" class="text-slate-400 hover:text-rose-600 p-1">✕</button>
                        </div>
                        <input type="text" name="req_descriptions[]" value="1 lembar fotokopi jelas" placeholder="Catatan tambahan"
                               class="w-full px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[11px] text-slate-600 focus:outline-none focus:border-desentra-teal">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- SECTION 3: Alur Prosedur / Langkah -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <h2 class="text-xs font-black uppercase tracking-wider text-desentra-teal">
                    3. Alur / Langkah Pengurusan
                </h2>
                <button type="button" onclick="addStepRow()" class="text-[11px] font-bold text-desentra-teal hover:underline flex items-center gap-1">
                    + Tambah Langkah
                </button>
            </div>
            
            <p class="text-[11px] text-slate-500">Tahapan yang harus dijalani warga dari awal hingga dokumen selesai.</p>

            <div id="stepsContainer" class="space-y-2">
                <?php 
                $existingSteps = [];
                if (!empty($guide['steps_json'])) {
                    $existingSteps = json_decode($guide['steps_json'], true) ?: [];
                }
                ?>
                <?php if (!empty($existingSteps)): ?>
                    <?php foreach ($existingSteps as $idx => $st): ?>
                        <div class="step-row p-2.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 relative">
                            <div class="flex items-center gap-2">
                                <span class="step-num text-[11px] font-black text-white bg-slate-800 rounded-full w-5 h-5 flex items-center justify-center shrink-0"><?= $idx + 1 ?></span>
                                <input type="text" name="step_titles[]" value="<?= esc($st['title'] ?? '') ?>" placeholder="Judul langkah (mis: Ambil Nomor Antrean)" required
                                       class="flex-1 px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-desentra-teal">
                                <button type="button" onclick="this.closest('.step-row').remove(); updateStepNumbers();" class="text-slate-400 hover:text-rose-600 p-1">✕</button>
                            </div>
                            <textarea name="step_descriptions[]" rows="1" placeholder="Penjelasan detail langkah..."
                                      class="w-full px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[11px] text-slate-600 focus:outline-none focus:border-desentra-teal"><?= esc($st['description'] ?? '') ?></textarea>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="step-row p-2.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 relative">
                        <div class="flex items-center gap-2">
                            <span class="step-num text-[11px] font-black text-white bg-slate-800 rounded-full w-5 h-5 flex items-center justify-center shrink-0">1</span>
                            <input type="text" name="step_titles[]" value="Datang ke Loket Pelayanan Kantor Desa" placeholder="Judul langkah" required
                                   class="flex-1 px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-desentra-teal">
                            <button type="button" onclick="this.closest('.step-row').remove(); updateStepNumbers();" class="text-slate-400 hover:text-rose-600 p-1">✕</button>
                        </div>
                        <textarea name="step_descriptions[]" rows="1" placeholder="Penjelasan detail..."
                                  class="w-full px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[11px] text-slate-600 focus:outline-none focus:border-desentra-teal">Bawa berkas persyaratan lengkap dan serahkan ke petugas loket.</textarea>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- SECTION 4: Status Alur Kerja (Workflow Status) -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-2.5">
            <h2 class="text-xs font-black uppercase tracking-wider text-desentra-teal border-b border-slate-100 pb-2">
                4. Status Publikasi & Alur Persetujuan
            </h2>

            <div class="space-y-2">
                <?php $curStatus = old('status', $guide['status'] ?? 'draft'); ?>

                <label class="flex items-start gap-2.5 p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                    <input type="radio" name="status" value="draft" <?= $curStatus === 'draft' ? 'checked' : '' ?> class="mt-0.5 text-desentra-teal focus:ring-0">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Draf (Konsep)</span>
                        <span class="text-[11px] text-slate-500">Hanya dapat dilihat oleh admin internal, belum tampil di warga atau AI.</span>
                    </div>
                </label>

                <label class="flex items-start gap-2.5 p-2 rounded-xl border border-amber-200 bg-amber-50/40 hover:bg-amber-50 cursor-pointer">
                    <input type="radio" name="status" value="pending_verification" <?= $curStatus === 'pending_verification' ? 'checked' : '' ?> class="mt-0.5 text-amber-600 focus:ring-0">
                    <div>
                        <span class="text-xs font-bold text-amber-900 block">Ajukan Verifikasi (Review)</span>
                        <span class="text-[11px] text-amber-700">Dikirim ke akun Verifikator untuk peninjauan regulasi.</span>
                    </div>
                </label>

                <?php if ($userRole === 'verifier' || $userRole === 'admin'): ?>
                    <label class="flex items-start gap-2.5 p-2 rounded-xl border border-emerald-200 bg-emerald-50/40 hover:bg-emerald-50 cursor-pointer">
                        <input type="radio" name="status" value="published" <?= $curStatus === 'published' ? 'checked' : '' ?> class="mt-0.5 text-emerald-600 focus:ring-0">
                        <div>
                            <span class="text-xs font-bold text-emerald-900 block">Terbitkan Sekarang (Published & Aktif AI)</span>
                            <span class="text-[11px] text-emerald-700">Langsung muncul di portal warga dan otomatis diindeks ke mesin AI RAG.</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-2.5 p-2 rounded-xl border border-rose-200 hover:bg-rose-50/50 cursor-pointer">
                        <input type="radio" name="status" value="needs_review" <?= $curStatus === 'needs_review' ? 'checked' : '' ?> class="mt-0.5 text-rose-600 focus:ring-0">
                        <div>
                            <span class="text-xs font-bold text-rose-800 block">Perlu Revisi</span>
                            <span class="text-[11px] text-rose-600">Minta editor memperbaiki isi panduan sebelum diterbitkan.</span>
                        </div>
                    </label>
                <?php else: ?>
                    <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl text-[11px] text-slate-500">
                        ℹ️ Sebagai <strong>Editor</strong>, penerbitan panduan ke publik akan diproses setelah diverifikasi oleh Verifikator Desa.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sticky Save Button -->
        <div class="fixed bottom-14 left-0 right-0 z-30 pointer-events-none">
            <div class="max-w-md mx-auto px-4 pointer-events-auto">
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-desentra-teal to-teal-800 text-white rounded-2xl font-black text-xs shadow-xl shadow-teal-900/20 active:scale-98 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span><?= $guide ? 'Simpan Perubahan Panduan' : 'Simpan Panduan Baru' ?></span>
                </button>
            </div>
        </div>

    </form>

</div>

<script>
let reqCount = <?= !empty($requirements) ? count($requirements) : 1 ?>;
function addRequirementRow() {
    const container = document.getElementById('requirementsContainer');
    const div = document.createElement('div');
    div.className = 'req-row p-2.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 relative';
    div.innerHTML = `
        <div class="flex items-center gap-2">
            <input type="text" name="req_titles[]" placeholder="Nama berkas persyaratan" required
                   class="flex-1 px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-desentra-teal">
            <label class="flex items-center gap-1 text-[11px] font-bold text-slate-700 whitespace-nowrap cursor-pointer">
                <input type="checkbox" name="req_mandatory[\${reqCount}]" value="1" checked class="rounded text-desentra-teal focus:ring-0">
                <span>Wajib</span>
            </label>
            <button type="button" onclick="this.closest('.req-row').remove()" class="text-slate-400 hover:text-rose-600 p-1">✕</button>
        </div>
        <input type="text" name="req_descriptions[]" placeholder="Catatan tambahan (mis: rangkap 2, asli/fotokopi)"
               class="w-full px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[11px] text-slate-600 focus:outline-none focus:border-desentra-teal">
    `;
    container.appendChild(div);
    reqCount++;
}

function addStepRow() {
    const container = document.getElementById('stepsContainer');
    const div = document.createElement('div');
    div.className = 'step-row p-2.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5 relative';
    div.innerHTML = `
        <div class="flex items-center gap-2">
            <span class="step-num text-[11px] font-black text-white bg-slate-800 rounded-full w-5 h-5 flex items-center justify-center shrink-0">?</span>
            <input type="text" name="step_titles[]" placeholder="Judul langkah" required
                   class="flex-1 px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none focus:border-desentra-teal">
            <button type="button" onclick="this.closest('.step-row').remove(); updateStepNumbers();" class="text-slate-400 hover:text-rose-600 p-1">✕</button>
        </div>
        <textarea name="step_descriptions[]" rows="1" placeholder="Penjelasan detail langkah..."
                  class="w-full px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-[11px] text-slate-600 focus:outline-none focus:border-desentra-teal"></textarea>
    `;
    container.appendChild(div);
    updateStepNumbers();
}

function updateStepNumbers() {
    const rows = document.querySelectorAll('#stepsContainer .step-row');
    rows.forEach((row, i) => {
        const num = row.querySelector('.step-num');
        if (num) num.textContent = i + 1;
    });
}
</script>
<?= $this->endSection() ?>
