<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 pb-28">

    <!-- Header & Back Button -->
    <div class="flex items-center gap-2 mb-4">
        <a href="<?= base_url('admin/info-desa') ?>" class="p-2 -ml-2 text-slate-500 hover:text-slate-800 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-base font-black text-slate-900 tracking-tight">
                <?= $info ? 'Edit Info Desa' : 'Buat Info Desa Baru' ?>
            </h1>
            <p class="text-[11px] text-slate-500 font-medium">Lengkapi pengumuman atau agenda kegiatan</p>
        </div>
    </div>

    <form method="POST" action="<?= $info ? base_url('admin/info-desa/update/' . $info['id']) : base_url('admin/info-desa/store') ?>" enctype="multipart/form-data" class="space-y-4">

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3.5">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Pengumuman / Info <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required value="<?= esc(old('title', $info['title'] ?? '')) ?>" 
                       placeholder="Contoh: Jadwal Imunisasi Balita Posyandu Melati" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-desentra-teal focus:bg-white">
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                    <select name="category" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white">
                        <?php
                        $cats = [
                            'announcement' => 'Pengumuman',
                            'schedule'     => 'Jadwal',
                            'agenda'       => 'Agenda Kegiatan',
                            'important'    => 'Penting / Mendesak',
                        ];
                        $curCat = old('category', $info['category'] ?? 'announcement');
                        foreach ($cats as $val => $lbl):
                        ?>
                            <option value="<?= $val ?>" <?= $curCat === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Berlaku Sampai (Opsional)</label>
                    <input type="date" name="valid_until" value="<?= esc(old('valid_until', $info['valid_until'] ?? '')) ?>" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Konten Lengkap <span class="text-rose-500">*</span></label>
                <textarea name="content" rows="4" required placeholder="Tuliskan isi pengumuman, lokasi, waktu, dan instruksi warga..." 
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white"><?= esc(old('content', $info['content'] ?? '')) ?></textarea>
            </div>
        </div>

        <!-- Poster Image Options -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-desentra-teal border-b border-slate-100 pb-2">
                Gambar Poster
            </h2>

            <!-- Current Poster Preview -->
            <?php if (!empty($info['banner_image'])): ?>
                <div class="flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="<?= base_url('img/' . $info['banner_image']) ?>" alt="Preview" class="w-14 h-16 object-cover rounded-lg border border-slate-200">
                    <div>
                        <span class="text-[11px] font-bold text-slate-700 block">Poster Aktif Saat Ini</span>
                        <span class="text-[10px] text-slate-400"><?= esc($info['banner_image']) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Option A: Upload File Baru -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Upload Poster Baru</label>
                <input type="file" name="banner_file" accept="image/*" 
                       class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-desentra-teal hover:file:bg-teal-100">
            </div>

            <!-- Option B: Pilih Template Poster Preset -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Atau Pilih Preset Gambar Cepat</label>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <?php
                    $presets = [
                        'poster-posyandu.png'     => 'Posyandu / Kesehatan',
                        'poster-musrenbangdes.png' => 'Musrenbang / Rapat',
                        'poster-hut-ri.png'       => 'Peringatan Hari Besar',
                        'poster-kantor-desa.png'  => 'Pelayanan Kantor Desa',
                        'poster-default.png'      => 'Pengumuman Standar',
                    ];
                    $curPreset = old('preset_banner', $info['banner_image'] ?? 'poster-default.png');
                    foreach ($presets as $file => $label):
                    ?>
                        <label class="flex items-center gap-2 p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            <input type="radio" name="preset_banner" value="<?= $file ?>" <?= $curPreset === $file ? 'checked' : '' ?> class="text-desentra-teal focus:ring-0">
                            <span class="text-[11px] font-medium text-slate-700"><?= $label ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-2">
            <h2 class="text-xs font-black uppercase tracking-wider text-desentra-teal border-b border-slate-100 pb-2">
                Status Publikasi
            </h2>
            <?php $statusVal = old('status', $info['status'] ?? 'published'); ?>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="status" value="published" <?= $statusVal === 'published' ? 'checked' : '' ?> class="text-emerald-600 focus:ring-0">
                    <span class="text-xs font-bold text-slate-800">Diterbitkan (Aktif)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="status" value="draft" <?= $statusVal === 'draft' ? 'checked' : '' ?> class="text-slate-600 focus:ring-0">
                    <span class="text-xs font-bold text-slate-800">Draf</span>
                </label>
            </div>
        </div>

        <!-- Sticky Save Button -->
        <div class="fixed bottom-14 left-0 right-0 z-30 pointer-events-none">
            <div class="max-w-md mx-auto px-4 pointer-events-auto">
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-desentra-teal to-teal-800 text-white rounded-2xl font-black text-xs shadow-xl shadow-teal-900/20 active:scale-98 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span><?= $info ? 'Simpan Perubahan Info Desa' : 'Terbitkan Info Desa' ?></span>
                </button>
            </div>
        </div>

    </form>

</div>
<?= $this->endSection() ?>
