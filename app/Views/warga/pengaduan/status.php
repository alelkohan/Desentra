<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-5 md:px-8 py-5 md:py-8 max-w-3xl mx-auto space-y-6">

    <!-- Back / Header -->
    <div>
        <a href="<?= base_url('pengaduan') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-desentra-teal transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali ke Form Pengaduan</span>
        </a>
    </div>

    <!-- Alert Sukses Buat Tiket -->
    <?php if ($ticketCreated): ?>
    <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-5 md:p-6 space-y-3 text-center shadow-xs">
        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center shadow-2xs">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="font-extrabold text-base md:text-lg text-emerald-800">Laporan Pengaduan Berhasil Dikirim!</h2>
        <p class="text-xs md:text-sm text-emerald-700 leading-relaxed max-w-md mx-auto">
            Simpan atau catat kode tiket unik berikut untuk melacak proses verifikasi dan tindak lanjut petugas desa:
        </p>
        <div class="inline-flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-emerald-300 font-mono font-black text-base text-emerald-900 select-all shadow-xs">
            <span><?= esc($ticketCode) ?></span>
            <button onclick="copyTicket('<?= esc($ticketCode) ?>')" class="text-xs text-desentra-teal font-sans font-extrabold hover:underline">
                Salin
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Search / Re-check Ticket Input -->
    <div class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-6 shadow-xs space-y-3">
        <label class="text-xs md:text-sm font-extrabold text-slate-800 block">Lacak Status Pengaduan Warga</label>
        <form action="<?= base_url('pengaduan/status') ?>" method="get" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="tiket" value="<?= esc($ticketCode ?? '') ?>" placeholder="Masukkan kode tiket (DSN-20261010-XXXX)..." required
                   class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs md:text-sm font-mono text-slate-800 uppercase focus:outline-none focus:ring-2 focus:ring-desentra-teal">
            <button type="submit" class="bg-desentra-teal text-white px-6 py-2.5 rounded-2xl text-xs md:text-sm font-bold shadow-xs hover:bg-teal-700 transition-colors">
                Lacak Tiket →
            </button>
        </form>
    </div>

    <!-- Ticket Detail Result -->
    <?php if ($complaint): ?>
    <div class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-7 shadow-xs space-y-5">
        
        <!-- Header Info -->
        <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <span class="text-[10px] md:text-xs font-mono font-bold text-slate-400 block">KODE TIKET RESMI</span>
                <span class="font-mono font-black text-base md:text-lg text-desentra-teal"><?= esc($complaint['ticket_code']) ?></span>
            </div>

            <!-- Status Badge -->
            <div>
                <?php
                    $statusStyles = [
                        'received'    => ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-700', 'label' => 'Diterima'],
                        'in_review'   => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'label' => 'Ditinjau Petugas'],
                        'in_progress' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-700', 'label' => 'Sedang Ditindaklanjuti'],
                        'resolved'    => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-700', 'label' => 'Selesai / Teratasi'],
                        'rejected'    => ['bg' => 'bg-rose-50', 'border' => 'border-rose-200', 'text' => 'text-rose-700', 'label' => 'Ditolak'],
                    ];
                    $badge = $statusStyles[$complaint['status']] ?? ['bg' => 'bg-slate-50', 'border' => 'border-slate-200', 'text' => 'text-slate-700', 'label' => $complaint['status']];
                ?>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold border <?= $badge['bg'] ?> <?= $badge['border'] ?> <?= $badge['text'] ?>">
                    <?= esc($badge['label']) ?>
                </span>
            </div>
        </div>

        <!-- Complaint Info -->
        <div class="space-y-2">
            <span class="text-[10px] md:text-xs font-bold text-desentra-teal uppercase tracking-wider bg-teal-50 px-2 py-0.5 rounded-md"><?= esc($complaint['category']) ?></span>
            <h3 class="font-extrabold text-base md:text-lg text-slate-900"><?= esc($complaint['title']) ?></h3>
            <p class="text-xs md:text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <?= esc($complaint['description']) ?>
            </p>
        </div>

        <!-- Attachment Preview if any -->
        <?php if (!empty($complaint['attachments'])): ?>
        <div class="space-y-2">
            <span class="text-[11px] md:text-xs font-bold text-slate-500 uppercase tracking-wider block">Foto Bukti Lampiran:</span>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <?php foreach ($complaint['attachments'] as $att): ?>
                <a href="<?= base_url($att['file_path']) ?>" target="_blank" class="block rounded-2xl overflow-hidden border border-slate-200 group">
                    <img src="<?= base_url($att['file_path']) ?>" alt="Foto Pengaduan" class="w-full h-32 object-cover group-hover:scale-105 transition-transform">
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Timeline Status Progress -->
        <div class="space-y-3 pt-3 border-t border-slate-100">
            <h4 class="font-extrabold text-xs md:text-sm text-slate-800">Riwayat Penanganan Oleh Kantor Desa</h4>

            <div class="space-y-3.5 pl-2 border-l-2 border-desentra-teal/30 ml-2">
                <?php foreach ($complaint['history'] as $h): ?>
                <div class="relative pl-6 text-xs md:text-sm space-y-1">
                    <div class="absolute -left-[14px] top-1 w-4 h-4 rounded-full bg-desentra-teal border-2 border-white shadow-xs"></div>
                    <div class="flex items-center justify-between text-[11px] text-slate-400">
                        <span class="font-extrabold uppercase text-slate-700"><?= esc($statusStyles[$h['status']]['label'] ?? $h['status']) ?></span>
                        <span><?= date('d M Y H:i', strtotime($h['created_at'])) ?> WIB</span>
                    </div>
                    <?php if (!empty($h['public_note'])): ?>
                    <p class="text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed">
                        <?= esc($h['public_note']) ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    <?php elseif ($ticketCode): ?>
    <div class="text-center py-12 bg-white rounded-3xl border border-slate-200 p-6 space-y-2 shadow-xs">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="font-extrabold text-sm md:text-base text-slate-800">Kode Tiket Tidak Ditemukan</h3>
        <p class="text-xs text-slate-500 max-w-sm mx-auto">
            Pastikan kode tiket yang dimasukkan sudah benar dan lengkap (Contoh: DSN-20261010-XXXX).
        </p>
    </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function copyTicket(code) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Kode tiket ' + code + ' telah disalin ke clipboard!');
        });
    }
</script>
<?= $this->endSection() ?>
