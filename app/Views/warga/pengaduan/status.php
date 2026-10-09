<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="px-4 py-5 space-y-5">

    <!-- Back / Header -->
    <div>
        <a href="<?= base_url('pengaduan') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-desentra-teal transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali ke Pengaduan</span>
        </a>
    </div>

    <!-- Alert Sukses Buat Tiket -->
    <?php if ($ticketCreated): ?>
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 space-y-2 text-center">
        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="font-bold text-sm text-emerald-800">Pengaduan Berhasil Dikirim!</h2>
        <p class="text-xs text-emerald-700 leading-relaxed">
            Simpan kode tiket berikut untuk melacak proses penanganan oleh admin desa:
        </p>
        <div class="inline-flex items-center gap-2 bg-white px-3 py-1.5 rounded-xl border border-emerald-300 font-mono font-extrabold text-sm text-emerald-900 select-all shadow-xs">
            <span><?= esc($ticketCode) ?></span>
            <button onclick="copyTicket('<?= esc($ticketCode) ?>')" class="text-xs text-desentra-teal font-sans font-bold hover:underline">
                Salin
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Search / Re-check Ticket Input -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm space-y-3">
        <label class="text-xs font-bold text-slate-700 block">Lacak Status Pengaduan</label>
        <form action="<?= base_url('pengaduan/status') ?>" method="get" class="flex gap-2">
            <input type="text" name="tiket" value="<?= esc($ticketCode ?? '') ?>" placeholder="Masukkan kode tiket..." required
                   class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-800 uppercase focus:outline-none focus:ring-2 focus:ring-desentra-teal">
            <button type="submit" class="bg-desentra-teal text-white px-4 py-2 rounded-xl text-xs font-bold shadow-xs hover:bg-desentra-teal/90 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Ticket Detail Result -->
    <?php if ($complaint): ?>
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm space-y-4">
        
        <!-- Header Info -->
        <div class="flex items-start justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <span class="text-[10px] font-mono font-bold text-slate-400 block">KODE TIKET</span>
                <span class="font-mono font-extrabold text-sm text-desentra-teal"><?= esc($complaint['ticket_code']) ?></span>
            </div>

            <!-- Status Badge -->
            <div>
                <?php
                    $statusStyles = [
                        'received'    => ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-700', 'label' => 'Diterima'],
                        'in_review'   => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'label' => 'Ditinjau'],
                        'in_progress' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-700', 'label' => 'Diproses'],
                        'resolved'    => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-700', 'label' => 'Selesai'],
                        'rejected'    => ['bg' => 'bg-rose-50', 'border' => 'border-rose-200', 'text' => 'text-rose-700', 'label' => 'Ditolak'],
                    ];
                    $badge = $statusStyles[$complaint['status']] ?? ['bg' => 'bg-slate-50', 'border' => 'border-slate-200', 'text' => 'text-slate-700', 'label' => $complaint['status']];
                ?>
                <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-bold border <?= $badge['bg'] ?> <?= $badge['border'] ?> <?= $badge['text'] ?>">
                    <?= esc($badge['label']) ?>
                </span>
            </div>
        </div>

        <!-- Complaint Info -->
        <div class="space-y-1.5">
            <span class="text-[10px] font-bold text-desentra-teal uppercase tracking-wider"><?= esc($complaint['category']) ?></span>
            <h3 class="font-bold text-sm text-slate-900"><?= esc($complaint['title']) ?></h3>
            <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">
                <?= esc($complaint['description']) ?>
            </p>
        </div>

        <!-- Attachment Preview if any -->
        <?php if (!empty($complaint['attachments'])): ?>
        <div class="space-y-1">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Foto Lampiran:</span>
            <div class="grid grid-cols-2 gap-2">
                <?php foreach ($complaint['attachments'] as $att): ?>
                <a href="<?= base_url($att['file_path']) ?>" target="_blank" class="block rounded-xl overflow-hidden border border-slate-200 group">
                    <img src="<?= base_url($att['file_path']) ?>" alt="Foto Pengaduan" class="w-full h-24 object-cover group-hover:scale-105 transition-transform">
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Timeline Status Progress -->
        <div class="space-y-3 pt-2 border-t border-slate-100">
            <h4 class="font-bold text-xs text-slate-800">Riwayat Penanganan</h4>

            <div class="space-y-3 pl-2 border-l-2 border-desentra-teal/30 ml-2">
                <?php foreach ($complaint['history'] as $h): ?>
                <div class="relative pl-5 text-xs space-y-0.5">
                    <div class="absolute -left-[13px] top-1 w-4 h-4 rounded-full bg-desentra-teal border-2 border-white shadow-xs"></div>
                    <div class="flex items-center justify-between text-[10px] text-slate-400">
                        <span class="font-bold uppercase text-slate-700"><?= esc($statusStyles[$h['status']]['label'] ?? $h['status']) ?></span>
                        <span><?= date('d M Y H:i', strtotime($h['created_at'])) ?></span>
                    </div>
                    <?php if (!empty($h['public_note'])): ?>
                    <p class="text-slate-600 bg-slate-50 p-2 rounded-lg border border-slate-100 mt-1">
                        <?= esc($h['public_note']) ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    <?php elseif ($ticketCode): ?>
    <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 p-6 space-y-2">
        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="font-bold text-sm text-slate-800">Tiket Tidak Ditemukan</h3>
        <p class="text-xs text-slate-500">
            Pastikan kode tiket yang dimasukkan sudah benar (Contoh: DSN-20261010-XXXX).
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
