<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-[calc(100vh-8.5rem)] md:h-[calc(100vh-12rem)] md:max-w-4xl md:mx-auto md:my-6 md:bg-white md:rounded-3xl md:border md:border-slate-200/90 md:shadow-md md:overflow-hidden">

    <!-- Header: Tanya Jawab Layanan di kiri, serta (i) dan (+) di kanan -->
    <div class="px-4 md:px-6 py-3 md:py-3.5 bg-white border-b border-slate-100 flex items-center justify-between shadow-xs">
        <a href="<?= base_url('/') ?>" class="flex items-center gap-2 text-slate-800 hover:text-desentra-teal font-extrabold text-sm md:text-base transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Tanya Jawab Layanan Desa</span>
        </a>

        <div class="flex items-center gap-2">
            <!-- Tombol Info (i) -->
            <button onclick="toggleInfoModal()" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:text-desentra-teal text-xs font-serif font-bold transition-colors shadow-2xs" title="Informasi Layanan">
                i
            </button>
            <!-- Tombol New Chat (+) -->
            <button onclick="clearChatHistory()" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:text-desentra-teal text-base font-bold transition-colors shadow-2xs" title="Percakapan Baru">
                +
            </button>
        </div>
    </div>

    <!-- Security Warning (PRD Rule 9) -->
    <div class="bg-amber-50/90 px-4 py-1.5 border-b border-amber-100 text-[10px] text-amber-800 flex items-center gap-1.5 font-medium">
        <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <span>Desentra tidak memerlukan NIK untuk informasi layanan. Hindari mengirim data pribadi sensitif.</span>
    </div>

    <!-- Chat Messages Scroll Area -->
    <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
        
        <!-- User Bubble Sesuai Sketsa Wireframe: "Hai!" -->
        <div class="flex justify-end">
            <div class="bg-gradient-desentra text-white rounded-3xl rounded-tr-sm px-4.5 py-2.5 max-w-[80%] text-xs shadow-xs font-bold leading-relaxed">
                Halo, saya ingin bertanya seputar layanan desa 👋
            </div>
        </div>

        <!-- Bot Bubble -->
        <div class="flex items-start gap-2.5 max-w-[90%]">
            <div class="w-8 h-8 rounded-full bg-desentra-teal text-white flex items-center justify-center shrink-0 text-xs font-extrabold shadow-xs">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <div class="bg-white border border-slate-200/90 rounded-3xl rounded-tl-sm p-4 shadow-xs space-y-3 text-xs">
                <p class="text-slate-800 font-bold leading-relaxed">
                    Halo! Ada yang bisa kami bantu seputar layanan di <strong>Desentra</strong>?
                </p>
                <p class="text-slate-500 text-[11px] font-medium leading-relaxed">
                    Semua jawaban panduan didasarkan pada dokumen regulasi dan SOP resmi desa.
                </p>

                <!-- Tombol Saran Pertanyaan Berbentuk Pill Sesuai Sketsa -->
                <div class="pt-1 flex flex-wrap gap-2" id="quick-chips">
                    <button type="button" onclick="askPreset('Urus SKTM')" class="bg-teal-50/70 hover:bg-desentra-teal hover:text-white text-desentra-teal text-[11px] font-bold px-3.5 py-1.5 rounded-full border border-desentra-teal/25 transition-all active:scale-95 shadow-2xs">
                        Urus SKTM
                    </button>
                    <button type="button" onclick="askPreset('Buat KTP')" class="bg-teal-50/70 hover:bg-desentra-teal hover:text-white text-desentra-teal text-[11px] font-bold px-3.5 py-1.5 rounded-full border border-desentra-teal/25 transition-all active:scale-95 shadow-2xs">
                        Buat KTP
                    </button>
                    <button type="button" onclick="askPreset('Akta Kelahiran')" class="bg-teal-50/70 hover:bg-desentra-teal hover:text-white text-desentra-teal text-[11px] font-bold px-3.5 py-1.5 rounded-full border border-desentra-teal/25 transition-all active:scale-95 shadow-2xs">
                        Akta Kelahiran
                    </button>
                    <button type="button" onclick="askPreset('Jam operasional kantor desa')" class="bg-teal-50/70 hover:bg-desentra-teal hover:text-white text-desentra-teal text-[11px] font-bold px-3.5 py-1.5 rounded-full border border-desentra-teal/25 transition-all active:scale-95 shadow-2xs">
                        Jam Buka Desa
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Input Bar Bawah -->
    <div class="p-3 bg-white border-t border-slate-200">
        <form id="chat-form" onsubmit="handleSend(event)" class="flex items-center gap-2 bg-slate-50 border border-slate-300 rounded-3xl p-1.5 pl-4 shadow-xs focus-within:ring-2 focus-within:ring-desentra-teal focus-within:border-transparent">
            
            <!-- Kolom Input Teks -->
            <input type="text" id="chat-input" 
                   placeholder="Ketik pertanyaan Anda seputar syarat surat..." 
                   autocomplete="off"
                   class="flex-1 bg-transparent py-1.5 text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none">

            <!-- Tombol Kirim -->
            <button type="submit" id="send-btn" 
                    class="w-8 h-8 rounded-full bg-desentra-teal hover:bg-[#00706d] text-white flex items-center justify-center shrink-0 shadow-xs shadow-desentra-teal/30 active:scale-95 disabled:opacity-40 transition-transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </form>
    </div>

</div>

<!-- Info Modal (i) -->
<div id="info-modal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-5 max-w-sm w-full space-y-3 shadow-xl">
        <div class="flex items-center justify-between">
            <h3 class="font-extrabold text-sm text-slate-900">Tentang Tanya Jawab Desentra</h3>
            <button onclick="toggleInfoModal()" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
        </div>
        <p class="text-xs text-slate-600 leading-relaxed">
            Layanan ini membantu warga mendapatkan informasi cepat mengenai alur birokrasi dan persyaratan berkas administrasi desa berdasarkan Peraturan Bupati dan Standar Pelayanan Operasional resmi desa.
        </p>
        <button onclick="toggleInfoModal()" class="w-full py-2 bg-desentra-teal text-white rounded-2xl text-xs font-bold hover:bg-[#00706d] transition-colors">
            Mengerti
        </button>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const quickChips = document.getElementById('quick-chips');

    function toggleInfoModal() {
        document.getElementById('info-modal').classList.toggle('hidden');
    }

    function askPreset(text) {
        chatInput.value = text;
        handleSend(new Event('submit'));
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function appendUserMessage(text) {
        const div = document.createElement('div');
        div.className = 'flex justify-end';
        div.innerHTML = `
            <div class="bg-gradient-desentra text-white rounded-3xl rounded-tr-sm px-4.5 py-2.5 max-w-[80%] text-xs shadow-xs font-bold leading-relaxed">
                ${escapeHtml(text)}
            </div>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
    }

    function appendLoadingMessage() {
        const id = 'loading-' + Date.now();
        const div = document.createElement('div');
        div.id = id;
        div.className = 'flex items-start gap-2.5 max-w-[90%]';
        div.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-desentra-teal text-white flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <div class="bg-white border border-slate-200 rounded-3xl rounded-tl-sm p-3.5 shadow-xs space-y-1">
                <div class="flex items-center space-x-1.5 py-1">
                    <div class="w-2 h-2 rounded-full bg-desentra-teal animate-bounce"></div>
                    <div class="w-2 h-2 rounded-full bg-desentra-teal animate-bounce" style="animation-delay: 0.15s"></div>
                    <div class="w-2 h-2 rounded-full bg-desentra-teal animate-bounce" style="animation-delay: 0.3s"></div>
                </div>
                <span class="text-[10px] text-slate-400 font-medium">Mencocokkan ke sumber panduan resmi...</span>
            </div>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
        return id;
    }

    function appendBotResponse(data) {
        const div = document.createElement('div');
        div.className = 'flex items-start gap-2.5 max-w-[90%]';
        
        let sourcesHtml = '';
        if (data.sources && data.sources.length > 0) {
            sourcesHtml = `
                <div class="mt-2.5 pt-2 border-t border-slate-100 space-y-1.5">
                    <span class="text-[10px] font-bold text-slate-500 block uppercase tracking-wider">Sumber Resmi Terbit:</span>
                    <div class="space-y-1">
                        ${data.sources.map(s => `
                            <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 text-[10px]">
                                <div class="font-bold text-desentra-teal">${escapeHtml(s.title)}</div>
                                <div class="text-slate-400">Ditinjau: ${escapeHtml(s.checked_at)}</div>
                                ${s.slug ? `<a href="/layanan/detail/${s.slug}" class="text-desentra-teal font-bold hover:underline block mt-0.5">Buka panduan lengkap →</a>` : ''}
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        let fallbackAction = '';
        if (data.is_fallback) {
            fallbackAction = `
                <div class="mt-3 pt-2.5 border-t border-slate-100 flex flex-col gap-1.5">
                    <a href="<?= base_url('pengaduan') ?>" class="inline-flex items-center justify-center gap-1 bg-desentra-orange text-white text-[11px] font-bold py-2 px-3.5 rounded-2xl shadow-xs">
                        Kirim Pertanyaan / Pengaduan ke Admin
                    </a>
                    ${data.official_contact ? `<span class="text-[10px] text-slate-500 text-center font-medium">Kontak desa: ${escapeHtml(data.official_contact)}</span>` : ''}
                </div>
            `;
        }

        let feedbackHtml = '';
        if (data.question_id) {
            feedbackHtml = `
                <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400" id="feedback-${data.question_id}">
                    <span>Jawaban membantu?</span>
                    <div class="flex items-center gap-2">
                        <button onclick="sendFeedback(${data.question_id}, 1)" class="p-1 hover:text-emerald-600 font-bold transition-colors">👍 Ya</button>
                        <button onclick="sendFeedback(${data.question_id}, -1)" class="p-1 hover:text-red-500 font-bold transition-colors">👎 Kurang</button>
                    </div>
                </div>
            `;
        }

        div.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-desentra-teal text-white flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <div class="bg-white border border-slate-200/90 rounded-3xl rounded-tl-sm p-4 shadow-xs space-y-2 text-xs">
                <div class="text-slate-800 leading-relaxed font-medium prose prose-sm max-w-none">
                    ${formatMarkdown(data.answer)}
                </div>
                ${sourcesHtml}
                ${fallbackAction}
                ${feedbackHtml}
            </div>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
    }

    async function handleSend(event) {
        event.preventDefault();
        const text = chatInput.value.trim();
        if (!text) return;

        chatInput.value = '';
        chatInput.disabled = true;
        sendBtn.disabled = true;

        appendUserMessage(text);
        const loadingId = appendLoadingMessage();

        try {
            const formData = new FormData();
            formData.append('question', text);

            const res = await fetch('<?= base_url('tanya/ask') ?>', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });

            const data = await res.json();
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();

            if (data.success) {
                appendBotResponse(data);
            } else {
                appendBotResponse({
                    answer: data.message || 'Terjadi kesalahan sistem. Silakan coba sesaat lagi.',
                    sources: []
                });
            }
        } catch (err) {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();

            appendBotResponse({
                answer: 'Koneksi terganggu. Silakan periksa kembali jaringan internet Anda.',
                sources: []
            });
        } finally {
            chatInput.disabled = false;
            sendBtn.disabled = false;
            chatInput.focus();
        }
    }

    async function sendFeedback(questionId, rating) {
        try {
            const formData = new FormData();
            formData.append('question_id', questionId);
            formData.append('rating', rating);

            await fetch('<?= base_url('tanya/feedback') ?>', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });

            const container = document.getElementById(`feedback-${questionId}`);
            if (container) {
                container.innerHTML = '<span class="text-emerald-600 font-bold">Terima kasih atas masukannya!</span>';
            }
        } catch (e) {}
    }

    function clearChatHistory() {
        window.showConfirmBottomSheet({
            title: 'Mulai Percakapan Baru?',
            message: 'Riwayat percakapan pada sesi ini akan dibersihkan dan percakapan akan dimulai kembali dari awal.',
            type: 'warning',
            confirmText: 'Ya, Mulai Baru',
            cancelText: 'Batal',
            onConfirm: function() {
                location.reload();
            }
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    }

    function formatMarkdown(text) {
        if (!text) return '';
        let escaped = escapeHtml(text);
        escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-900">$1</strong>');
        escaped = escaped.replace(/\*(.*?)\*/g, '<em class="italic text-slate-700">$1</em>');

        const lines = escaped.split('\n');
        let formatted = '';
        lines.forEach(line => {
            const trimmed = line.trim();
            if (trimmed.startsWith('•') || trimmed.startsWith('-')) {
                const content = trimmed.replace(/^[•\-]\s*/, '');
                formatted += `<div class="flex items-start gap-2 my-1 pl-1"><span class="text-desentra-teal font-extrabold shrink-0 mt-0.5">•</span><span class="leading-relaxed">${content}</span></div>`;
            } else if (/^\d+\.\s/.test(trimmed)) {
                const match = trimmed.match(/^(\d+)\.\s(.*)$/);
                if (match) {
                    formatted += `<div class="flex items-start gap-2 my-1.5 pl-1"><span class="w-5 h-5 rounded-full bg-teal-50 text-desentra-teal text-[10px] font-extrabold flex items-center justify-center shrink-0 border border-teal-200/80 shadow-2xs mt-0.5">${match[1]}</span><span class="leading-relaxed">${match[2]}</span></div>`;
                } else {
                    formatted += `<div class="my-0.5 leading-relaxed">${trimmed}</div>`;
                }
            } else if (trimmed === '') {
                formatted += '<div class="h-2"></div>';
            } else {
                formatted += `<div class="my-0.5 leading-relaxed">${line}</div>`;
            }
        });
        return formatted;
    }
</script>
<?= $this->endSection() ?>
