<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-5 py-5 space-y-6">

    <!-- Header Sesuai Wireframe: Judul Pengaduan + Ikon Headset Kanan Atas -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-black tracking-tight text-slate-900 font-sans">
            Pengaduan
        </h1>
        <div class="w-10 h-10 rounded-full bg-desentra-teal/10 flex items-center justify-center text-desentra-teal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 10.5C4.5 6.358 7.858 3 12 3s7.5 3.358 7.5 7.5v4.5a3 3 0 01-3 3H15M4.5 10.5v4.5a3 3 0 003 3H9"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Lacak Tiket Box (Akses Cepat) -->
    <div class="bg-slate-50 border border-slate-200 rounded-3xl p-3.5 shadow-2xs">
        <form action="<?= base_url('pengaduan/status') ?>" method="get" class="flex gap-2">
            <input type="text" name="tiket" placeholder="Punya kode tiket? (DSN-20261010-XXXX)" required
                   class="flex-1 px-4 py-2 bg-white border border-slate-200 rounded-2xl text-xs font-mono uppercase text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal">
            <button type="submit" class="bg-desentra-teal text-white px-5 py-2 rounded-2xl text-xs font-bold shadow-xs hover:bg-teal-700 transition-colors">
                Lacak
            </button>
        </form>
    </div>

    <!-- Form Pengaduan Sesuai Anatomi Sketsa Wireframe -->
    <form action="<?= base_url('pengaduan/submit') ?>" method="post" enctype="multipart/form-data" class="space-y-4"
          data-confirm="Pastikan data masalah dan lampiran foto sudah sesuai sebelum dikirimkan ke petugas desa." 
          data-confirm-title="Kirim Laporan Pengaduan?" 
          data-confirm-type="info" 
          data-confirm-btn="Ya, Kirim Laporan">
        <?= csrf_field() ?>

        <?php if (!empty($errors)): ?>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-3 text-xs text-red-600 space-y-1">
            <strong class="font-bold block">Mohon lengkapi isian:</strong>
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Kategori (Dropdown Pill) -->
        <div class="space-y-1">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Kategori</label>
            <select name="category" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-3xl text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs">
                <option value="layanan">Layanan Administrasi Desa</option>
                <option value="infrastruktur">Infrastruktur & Jalan / Fasilitas Umum</option>
                <option value="kebersihan">Kebersihan & Lingkungan</option>
                <option value="administrasi">Pungli / Ketidaksesuaian Prosedur</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <!-- 1. Input Bentuk Pill: Judul Pengaduan Sesuai Sketsa -->
        <div class="space-y-1">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Judul Pengaduan</label>
            <input type="text" name="title" value="<?= old('title') ?>" required
                   placeholder="Judul Pengaduan" 
                   class="w-full px-4 py-3 bg-white border border-slate-200 rounded-3xl text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs">
        </div>

        <!-- 2. Textarea Rounded Box: Deskripsi: Sesuai Sketsa -->
        <div class="space-y-1">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Deskripsi:</label>
            <textarea name="description" rows="5" required
                      placeholder="Tuliskan laporan permasalahan atau aspirasi Anda secara lengkap..." 
                      class="w-full p-4 bg-white border border-slate-200 rounded-3xl text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs"><?= old('description') ?></textarea>
        </div>

        <!-- 3. Dokumentasi: 3 Slot Kotak Media Horizontal Sesuai Sketsa Wireframe -->
        <div class="space-y-2">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Dokumentasi:</label>
            
            <div class="grid grid-cols-3 gap-2.5">
                
                <!-- Slot 1 (Thumbnail Pratinjau / Kotak Foto 1) -->
                <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center relative overflow-hidden group cursor-pointer" onclick="document.getElementById('photo-input').click()">
                    <img id="preview-img-1" class="hidden w-full h-full object-cover">
                    <div id="placeholder-1" class="flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-[9px] mt-1 font-semibold">Foto 1</span>
                    </div>
                </div>

                <!-- Slot 2 (Kotak Foto 2) -->
                <div class="aspect-square rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center relative overflow-hidden cursor-pointer" onclick="document.getElementById('photo-input').click()">
                    <div class="flex flex-col items-center justify-center text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-[9px] mt-1 font-medium">Foto 2</span>
                    </div>
                </div>

                <!-- Slot 3 (Tombol Tambah [+] Sesuai Sketsa) -->
                <label for="photo-input" class="aspect-square rounded-2xl border-2 border-slate-300 hover:border-desentra-teal bg-white flex flex-col items-center justify-center cursor-pointer shadow-2xs hover:bg-slate-50 transition-all">
                    <span class="text-2xl font-light text-slate-600 leading-none">+</span>
                    <span class="text-[9px] text-slate-500 font-bold mt-1">Unggah</span>
                </label>

            </div>

            <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
            <p class="text-[10px] text-slate-400">Klik tanda (+) untuk memilih foto lampiran JPG, PNG, atau WEBP.</p>
        </div>

        <!-- Kontak Balasan Opsional -->
        <div class="space-y-1">
            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Kontak WhatsApp / No. HP (Opsional)</label>
            <input type="text" name="contact" value="<?= old('contact') ?>"
                   placeholder="08xxxxxxxxxx" 
                   class="w-full px-4 py-3 bg-white border border-slate-200 rounded-3xl text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal shadow-xs">
        </div>

        <!-- 4. Tombol Lebar Berbentuk Pill Sesuai Sketsa: [ Kirim pengaduan ] (BSI Orange Aksen PRD) -->
        <div class="pt-3">
            <button type="submit" 
                    class="w-full py-3.5 rounded-full bg-gradient-to-r from-desentra-orange to-[#F29F28] text-white font-extrabold text-xs shadow-md shadow-desentra-orange/25 hover:opacity-95 active:scale-[0.98] transition-all">
                Kirim pengaduan
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
