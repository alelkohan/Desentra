<!-- Global Mobile Bottom Sheet Confirmation Component -->
<div id="globalBottomSheetBackdrop" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300 opacity-0 pointer-events-none flex items-end justify-center">
    
    <div id="globalBottomSheet" class="w-full max-w-md bg-white rounded-t-3xl p-5 shadow-2xl transition-transform duration-300 ease-out translate-y-full transform pb-safe-bottom select-none">
        <!-- Drag Handle Indicator -->
        <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-4"></div>

        <!-- Dynamic Thematic Icon Box -->
        <div id="bottomSheetIconContainer" class="w-12 h-12 rounded-2xl mx-auto flex items-center justify-center mb-3">
            <!-- Icon rendered dynamically -->
        </div>

        <!-- Title & Message -->
        <div class="text-center space-y-1 mb-5">
            <h3 id="bottomSheetTitle" class="text-base font-black text-slate-900 tracking-tight leading-snug">
                Konfirmasi
            </h3>
            <p id="bottomSheetMessage" class="text-xs text-slate-500 font-medium leading-relaxed max-w-xs mx-auto">
                Apakah Anda yakin ingin melanjutkan tindakan ini?
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2">
            <button type="button" id="bottomSheetConfirmBtn" class="w-full py-3 rounded-2xl font-black text-xs text-white shadow-md active:scale-98 transition-all flex items-center justify-center gap-2">
                <span id="bottomSheetConfirmText">Ya, Lanjutkan</span>
            </button>
            <button type="button" id="bottomSheetCancelBtn" class="w-full py-2.5 rounded-2xl font-bold text-xs text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors text-center">
                <span id="bottomSheetCancelText">Batal</span>
            </button>
        </div>
    </div>

</div>

<script>
(function() {
    const backdrop   = document.getElementById('globalBottomSheetBackdrop');
    const sheet      = document.getElementById('globalBottomSheet');
    const iconBox    = document.getElementById('bottomSheetIconContainer');
    const titleEl    = document.getElementById('bottomSheetTitle');
    const msgEl      = document.getElementById('bottomSheetMessage');
    const confirmBtn = document.getElementById('bottomSheetConfirmBtn');
    const cancelBtn  = document.getElementById('bottomSheetCancelBtn');
    const confirmTxt = document.getElementById('bottomSheetConfirmText');
    const cancelTxt  = document.getElementById('bottomSheetCancelText');

    let currentConfirmCallback = null;

    const iconTemplates = {
        danger: {
            bg: 'bg-rose-50 text-rose-600 border border-rose-200',
            btn: 'bg-rose-600 hover:bg-rose-700 shadow-rose-900/20',
            svg: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>`
        },
        warning: {
            bg: 'bg-amber-50 text-amber-600 border border-amber-200',
            btn: 'bg-amber-500 hover:bg-amber-600 shadow-amber-900/20',
            svg: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                  </svg>`
        },
        success: {
            bg: 'bg-emerald-50 text-emerald-600 border border-emerald-200',
            btn: 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-900/20',
            svg: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                  </svg>`
        },
        info: {
            bg: 'bg-teal-50 text-desentra-teal border border-teal-200',
            btn: 'bg-desentra-teal hover:bg-teal-700 shadow-teal-900/20',
            svg: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>`
        }
    };

    window.showConfirmBottomSheet = function(opts) {
        const type = opts.type || 'warning';
        const conf = iconTemplates[type] || iconTemplates.warning;

        titleEl.textContent = opts.title || 'Konfirmasi Tindakan';
        msgEl.textContent   = opts.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        confirmTxt.textContent = opts.confirmText || 'Ya, Lanjutkan';
        cancelTxt.textContent  = opts.cancelText || 'Batal';

        // Apply theme classes
        iconBox.className = 'w-12 h-12 rounded-2xl mx-auto flex items-center justify-center mb-3 ' + conf.bg;
        iconBox.innerHTML = conf.svg;

        confirmBtn.className = 'w-full py-3 rounded-2xl font-black text-xs text-white shadow-md active:scale-98 transition-all flex items-center justify-center gap-2 ' + conf.btn;

        currentConfirmCallback = opts.onConfirm || null;

        // Open bottom sheet
        backdrop.classList.remove('pointer-events-none', 'opacity-0');
        backdrop.classList.add('opacity-100');
        sheet.classList.remove('translate-y-full');
        sheet.classList.add('translate-y-0');
        document.body.style.overflow = 'hidden';
    };

    window.closeConfirmBottomSheet = function() {
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        sheet.classList.remove('translate-y-0');
        sheet.classList.add('translate-y-full');
        document.body.style.overflow = '';
        currentConfirmCallback = null;
    };

    confirmBtn.addEventListener('click', function() {
        const cb = currentConfirmCallback;
        window.closeConfirmBottomSheet();
        if (typeof cb === 'function') {
            cb();
        }
    });

    cancelBtn.addEventListener('click', window.closeConfirmBottomSheet);

    backdrop.addEventListener('click', function(e) {
        if (e.target === backdrop) {
            window.closeConfirmBottomSheet();
        }
    });

    // Auto Interceptor for elements with data-confirm
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form.hasAttribute('data-confirm') && !form.dataset.confirmed) {
            e.preventDefault();
            window.showConfirmBottomSheet({
                title: form.getAttribute('data-confirm-title') || 'Konfirmasi',
                message: form.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan?',
                type: form.getAttribute('data-confirm-type') || 'warning',
                confirmText: form.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan',
                cancelText: form.getAttribute('data-cancel-btn') || 'Batal',
                onConfirm: function() {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        }
    }, true);

    document.addEventListener('click', function(e) {
        const target = e.target.closest('a[data-confirm], button[data-confirm]');
        if (!target) return;
        
        // If it's a form submit button inside a data-confirm form, let the form handler handle it
        if (target.type === 'submit' && target.form && target.form.hasAttribute('data-confirm')) {
            return;
        }

        e.preventDefault();
        window.showConfirmBottomSheet({
            title: target.getAttribute('data-confirm-title') || 'Konfirmasi',
            message: target.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan?',
            type: target.getAttribute('data-confirm-type') || 'warning',
            confirmText: target.getAttribute('data-confirm-btn') || 'Ya, Lanjutkan',
            cancelText: target.getAttribute('data-cancel-btn') || 'Batal',
            onConfirm: function() {
                if (target.tagName.toLowerCase() === 'a' && target.href) {
                    window.location.href = target.href;
                } else if (target.type === 'submit' && target.form) {
                    target.form.submit();
                }
            }
        });
    }, true);
})();
</script>
