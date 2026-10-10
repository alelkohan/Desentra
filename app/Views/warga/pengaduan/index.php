<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-5 md:px-8 py-5 md:py-8 max-w-4xl mx-auto space-y-6 md:space-y-8">

    <!-- Header Sesuai Wireframe: Judul Pengaduan + Ikon Headset Kanan Atas -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900 font-sans">
                Kanal Aspirasi & Pengaduan
            </h1>
            <p class="text-xs md:text-sm text-slate-500 font-medium mt-0.5">
                Sampaikan kendala layanan, fasilitas desa, atau saran perbaikan secara transparan.
            </p>
        </div>
        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-desentra-teal/10 flex items-center justify-center text-desentra-teal shadow-2xs shrink-0">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 10.5C4.5 6.358 7.858 3 12 3s7.5 3.358 7.5 7.5v4.5a3 3 0 01-3 3H15M4.5 10.5v4.5a3 3 0 003 3H9"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Lacak Tiket Box (Akses Cepat) -->
    <div class="bg-white md:bg-slate-50 border border-slate-200 rounded-3xl p-4 md:p-5 shadow-2xs">
        <div class="text-xs font-bold text-slate-700 mb-2">Sudah pernah melapor? Cek status tiket Anda:</div>
        <form action="<?= base_url('pengaduan/status') ?>" method="get" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="tiket" placeholder="Masukkan kode tiket (DSN-20261010-XXXX)..." required
                   class="flex-1 px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-mono uppercase text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal">
            <button type="submit" class="bg-desentra-teal text-white px-6 py-2.5 rounded-2xl text-xs font-bold shadow-xs hover:bg-teal-700 transition-colors">
                Lacak Tiket →
            </button>
        </form>
    </div>

    <!-- Form Pengaduan Sesuai Anatomi Sketsa Wireframe -->
    <form action="<?= base_url('pengaduan/submit') ?>" method="post" enctype="multipart/form-data" class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-8 shadow-xs space-y-5"
          data-confirm="Pastikan data masalah dan lampiran foto sudah sesuai sebelum dikirimkan ke petugas desa." 
          data-confirm-title="Kirim Laporan Pengaduan?" 
          data-confirm-type="info" 
          data-confirm-btn="Ya, Kirim Laporan">
        <?= csrf_field() ?>

        <?php if (!empty($errors)): ?>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-xs text-red-600 space-y-1">
            <strong class="font-bold block">Mohon lengkapi isian:</strong>
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Baris Grid 2 Kolom pada Desktop untuk Kategori & Kontak -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <!-- Kategori (Dropdown Pill) -->
            <div class="space-y-1.5">
                <label class="text-[11px] md:text-xs font-bold text-slate-600 uppercase tracking-wider block">Kategori Laporan</label>
                <select name="category" required class="w-full px-4 py-3 bg-slate-50 md:bg-white border border-slate-200 rounded-2xl text-xs md:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs">
                    <option value="layanan">Layanan Administrasi Desa</option>
                    <option value="infrastruktur">Infrastruktur & Jalan / Fasilitas Umum</option>
                    <option value="kebersihan">Kebersihan & Lingkungan</option>
                    <option value="administrasi">Pungli / Ketidaksesuaian Prosedur</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <!-- Kontak Balasan Opsional -->
            <div class="space-y-1.5">
                <label class="text-[11px] md:text-xs font-bold text-slate-600 uppercase tracking-wider block">No. WhatsApp / HP (Opsional)</label>
                <input type="text" name="contact" value="<?= old('contact') ?>"
                       placeholder="Contoh: 081234567890 (untuk notifikasi)" 
                       class="w-full px-4 py-3 bg-slate-50 md:bg-white border border-slate-200 rounded-2xl text-xs md:text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs">
            </div>
        </div>

        <!-- 1. Input Bentuk Pill: Judul Pengaduan Sesuai Sketsa -->
        <div class="space-y-1.5">
            <label class="text-[11px] md:text-xs font-bold text-slate-600 uppercase tracking-wider block">Judul Permasalahan</label>
            <input type="text" name="title" value="<?= old('title') ?>" required
                   placeholder="Contoh: Lampu jalan padam di RT 03 / Kendala pengajuan surat" 
                   class="w-full px-4 py-3 bg-slate-50 md:bg-white border border-slate-200 rounded-2xl text-xs md:text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs">
        </div>

        <!-- 2. Textarea Rounded Box: Deskripsi: Sesuai Sketsa -->
        <div class="space-y-1.5">
            <label class="text-[11px] md:text-xs font-bold text-slate-600 uppercase tracking-wider block">Deskripsi Lengkap Kejadian / Keluhan</label>
            <textarea name="description" rows="5" required
                      placeholder="Tuliskan laporan permasalahan atau aspirasi Anda secara rinci (lokasi, kronologi, dll)..." 
                      class="w-full p-4 bg-slate-50 md:bg-white border border-slate-200 rounded-2xl text-xs md:text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs"><?= old('description') ?></textarea>
        </div>

        <!-- 3. Dokumentasi: 3 Slot Kotak Media Horizontal Sesuai Sketsa Wireframe -->
        <div class="space-y-2">
            <label class="text-[11px] md:text-xs font-bold text-slate-600 uppercase tracking-wider block">Lampiran Foto Bukti (Maks. 3 Foto)</label>
            
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                
                <!-- Slot 1 (Thumbnail Pratinjau / Kotak Foto 1) -->
                <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center relative overflow-hidden group cursor-pointer" onclick="document.getElementById('photo-input').click()">
                    <img id="preview-img-1" class="hidden w-full h-full object-cover">
                    <div id="placeholder-1" class="flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-[9px] md:text-[10px] mt-1 font-semibold">Foto 1</span>
                    </div>
                </div>

                <!-- Slot 2 (Kotak Foto 2) -->
                <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center relative overflow-hidden cursor-pointer" onclick="document.getElementById('photo-input').click()">
                    <div class="flex flex-col items-center justify-center text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-[9px] md:text-[10px] mt-1 font-medium">Foto 2</span>
                    </div>
                </div>

                <!-- Slot 3 (Tombol Tambah [+] Sesuai Sketsa) -->
                <label for="photo-input" class="aspect-square rounded-2xl border-2 border-slate-300 hover:border-desentra-teal bg-white flex flex-col items-center justify-center cursor-pointer shadow-2xs hover:bg-slate-50 transition-all">
                    <span class="text-2xl font-light text-slate-600 leading-none">+</span>
                    <span class="text-[9px] md:text-[10px] text-slate-500 font-bold mt-1">Unggah</span>
                </label>

            </div>

            <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
            <p class="text-[10px] md:text-xs text-slate-400">Klik tanda (+) untuk memilih foto lampiran (JPG, PNG, atau WEBP, maks 3MB).</p>
        </div>

        <!-- 4. Tombol Lebar Berbentuk Pill Sesuai Sketsa: [ Kirim pengaduan ] (BSI Orange Aksen PRD) -->
        <div class="pt-3">
            <button type="submit" 
                    class="w-full md:w-auto md:min-w-[240px] px-8 py-3.5 rounded-full bg-gradient-to-r from-desentra-orange to-[#F29F28] text-white font-extrabold text-xs md:text-sm shadow-md shadow-desentra-orange/25 hover:opacity-95 active:scale-[0.98] transition-all block mx-auto text-center">
                Kirim Pengaduan Sekarang →
            </button>
        </div>
    </form>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-img-1');
                const placeholder = document.getElementById('placeholder-1');
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>
