<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="px-4 py-4 pb-28">

    <!-- Header & Back Button -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <a href="<?= base_url('admin/pengaduan') ?>" class="p-2 -ml-2 text-slate-500 hover:text-slate-800 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-base font-black text-slate-900 tracking-tight">Detail Pengaduan</h1>
                <p class="text-[11px] font-mono font-bold text-desentra-teal"><?= esc($complaint['ticket_code']) ?></p>
            </div>
        </div>

        <a href="<?= base_url('pengaduan/status/' . $complaint['ticket_code']) ?>" target="_blank" 
           class="p-2 text-slate-400 hover:text-desentra-teal text-xs flex items-center gap-1 font-semibold" title="Buka Halaman Publik Warga">
            <span>Publik</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
        </a>
    </div>

    <!-- TICKET OVERVIEW CARD -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3 mb-4">
        
        <?php
        $statusBadges = [
            'received'    => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'label' => 'Diterima'],
            'in_review'   => ['bg' => 'bg-blue-50', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'label' => 'Ditelaah'],
            'in_progress' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-800', 'border' => 'border-teal-200', 'label' => 'Diproses'],
            'resolved'    => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200', 'label' => 'Selesai'],
            'rejected'    => ['bg' => 'bg-rose-50', 'text' => 'text-rose-800', 'border' => 'border-rose-200', 'label' => 'Ditolak'],
        ];
        $badge = $statusBadges[$complaint['status']] ?? $statusBadges['received'];
        ?>

        <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-2.5">
            <span class="text-[10px] font-bold text-desentra-teal uppercase tracking-wider bg-teal-50 px-2 py-0.5 rounded">
                Kategori: <?= esc($complaint['category']) ?>
            </span>
            <span class="text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full border <?= $badge['bg'] ?> <?= $badge['text'] ?> <?= $badge['border'] ?>">
                Status: <?= esc($badge['label']) ?>
            </span>
        </div>

        <div>
            <h2 class="text-sm font-black text-slate-900 leading-snug mb-1.5">
                <?= esc($complaint['title']) ?>
            </h2>
            <p class="text-xs text-slate-600 leading-relaxed font-normal whitespace-pre-line bg-slate-50 p-3 rounded-xl border border-slate-100">
                <?= esc($complaint['description']) ?>
            </p>
        </div>

        <!-- Pelapor Info -->
        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
            <div>
                <span class="text-[10px] text-slate-400 block font-medium">Kontak Warga:</span>
                <span class="font-bold text-slate-800"><?= esc($complaint['contact_reply'] ?: 'Tidak dicantumkan (Anonim)') ?></span>
            </div>
            <?php if (!empty($complaint['contact_reply'])): ?>
                <?php 
                $cleanPhone = preg_replace('/[^0-9]/', '', $complaint['contact_reply']);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                ?>
                <a href="https://wa.me/<?= $cleanPhone ?>" target="_blank" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-[11px] font-bold flex items-center gap-1 transition-colors">
                    <span>Chat WA</span>
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="text-[10px] text-slate-400">
            Diterima pada: <?= date('d M Y, H:i', strtotime($complaint['created_at'])) ?> WIB
        </div>
    </div>

    <!-- LAMPIRAN FOTO -->
    <?php if (!empty($attachments)): ?>
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-2.5 mb-4">
            <h3 class="text-xs font-black uppercase tracking-wider text-desentra-teal border-b border-slate-100 pb-2">
                Lampiran Bukti Foto Warga
            </h3>
            <div class="grid grid-cols-2 gap-2">
                <?php foreach ($attachments as $att): ?>
                    <a href="<?= base_url($att['file_path']) ?>" target="_blank" class="block rounded-xl overflow-hidden border border-slate-200 bg-slate-100 aspect-video relative group">
                        <img src="<?= base_url($att['file_path']) ?>" alt="Bukti aduan" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-[11px] font-bold">
                            Perbesar ↗
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- STATUS TIMELINE & NOTES -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3 mb-4">
        <h3 class="text-xs font-black uppercase tracking-wider text-desentra-teal border-b border-slate-100 pb-2">
            Riwayat Tindak Lanjut & Catatan
        </h3>

        <?php if (empty($history)): ?>
            <p class="text-xs text-slate-400">Belum ada riwayat tercatat.</p>
        <?php else: ?>
            <div class="space-y-3 relative pl-3 border-l-2 border-slate-200 ml-2">
                <?php foreach ($history as $h): ?>
                    <?php
                    $hBadge = $statusBadges[$h['status']] ?? $statusBadges['received'];
                    ?>
                    <div class="relative pl-3">
                        <!-- Bullet dot -->
                        <div class="absolute -left-[19px] top-1 w-3 h-3 rounded-full border-2 border-white bg-desentra-teal shadow-2xs"></div>

                        <div class="flex items-center justify-between gap-1 mb-1">
                            <span class="text-[10px] font-extrabold uppercase px-2 py-0.2 rounded-full border <?= $hBadge['bg'] ?> <?= $hBadge['text'] ?> <?= $hBadge['border'] ?>">
                                <?= esc($hBadge['label']) ?>
                            </span>
                            <span class="text-[10px] text-slate-400">
                                <?= date('d M, H:i', strtotime($h['created_at'])) ?>
                            </span>
                        </div>

                        <?php if (!empty($h['admin_name'])): ?>
                            <span class="text-[10px] text-slate-400 block font-medium">
                                Oleh: <strong class="text-slate-700"><?= esc($h['admin_name']) ?></strong> (<?= esc($h['admin_role'] ?? 'Petugas') ?>)
                            </span>
                        <?php endif; ?>

                        <!-- Public Note -->
                        <?php if (!empty($h['public_note'])): ?>
                            <div class="mt-1 p-2 bg-emerald-50/60 border border-emerald-100 rounded-lg text-xs text-slate-700 font-medium">
                                <span class="text-[9px] font-bold uppercase text-emerald-800 block">Catatan untuk Warga:</span>
                                <?= esc($h['public_note']) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Internal Note -->
                        <?php if (!empty($h['internal_note'])): ?>
                            <div class="mt-1 p-2 bg-amber-50/60 border border-amber-100 rounded-lg text-xs text-slate-700 font-medium">
                                <span class="text-[9px] font-bold uppercase text-amber-800 block">Catatan Internal Petugas:</span>
                                <?= esc($h['internal_note']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- UPDATE STATUS ACTION FORM -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs space-y-3">
        <h3 class="text-xs font-black uppercase tracking-wider text-desentra-teal border-b border-slate-100 pb-2">
            Perbarui Status & Beri Respon
        </h3>

        <form method="POST" action="<?= base_url('admin/pengaduan/status/' . $complaint['id']) ?>" class="space-y-3"
              data-confirm="Status penanganan dan catatan respon akan diperbarui dan dapat dilihat oleh warga pelapor." 
              data-confirm-title="Perbarui Status Tiket?" 
              data-confirm-type="info" 
              data-confirm-btn="Ya, Simpan Perubahan">
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Status Baru</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold focus:outline-none focus:border-desentra-teal focus:bg-white">
                    <option value="received" <?= $complaint['status'] === 'received' ? 'selected' : '' ?>>1. Diterima (Menunggu Antrean Telaah)</option>
                    <option value="in_review" <?= $complaint['status'] === 'in_review' ? 'selected' : '' ?>>2. Ditelaah (Verifikasi & Koordinasi Internal)</option>
                    <option value="in_progress" <?= $complaint['status'] === 'in_progress' ? 'selected' : '' ?>>3. Diproses (Tindakan di Lapangan / Tindak Lanjut)</option>
                    <option value="resolved" <?= $complaint['status'] === 'resolved' ? 'selected' : '' ?>>4. Selesai (Penanganan Tuntas)</option>
                    <option value="rejected" <?= $complaint['status'] === 'rejected' ? 'selected' : '' ?>>5. Ditolak (Di luar kewenangan desa / Tidak valid)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    Catatan untuk Warga Pelapor <span class="text-emerald-600 font-normal">(Terlihat di Lacak Aduan)</span>
                </label>
                <textarea name="public_note" rows="2" placeholder="Contoh: Laporan telah diteruskan ke Kepala Dusun / Tim teknis segera ke lokasi besok..."
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    Catatan Internal Petugas <span class="text-amber-600 font-normal">(Rahasia / Arsip Kantor)</span>
                </label>
                <textarea name="internal_note" rows="2" placeholder="Contoh: Menunggu pengadaan material semen atau koordinasi lintas dinas..."
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-desentra-teal focus:bg-white"></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 bg-desentra-teal hover:bg-teal-700 text-white rounded-xl font-bold text-xs shadow-md active:scale-98 transition-all flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Simpan Pembaruan Tiket</span>
            </button>

        </form>
    </div>

</div>
<?= $this->endSection() ?>
