<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= esc($title ?? 'Login Petugas - Desentra Admin') ?></title>
    
    <link rel="icon" type="image/svg+xml" href="<?= base_url('img/icon.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-full flex items-center justify-center p-4 font-sans text-desentra-dark antialiased bg-slate-100">

    <div class="w-full max-w-sm bg-white rounded-3xl shadow-xl border border-slate-200/90 p-6 space-y-6">
        
        <!-- Header Branding (BSI Teal & Gold Sparkle) -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-tr from-desentra-teal to-desentra-turquoise p-0.5 shadow-md shadow-desentra-teal/20 flex items-center justify-center">
                <img src="<?= base_url('img/icon.svg') ?>" alt="Desentra" class="w-full h-full rounded-2xl">
            </div>
            
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight flex items-center justify-center gap-1">
                    <span>Desentra Admin</span>
                    <span class="w-2 h-2 rounded-full bg-desentra-orange"></span>
                </h1>
                <p class="text-xs text-slate-500 font-medium">
                    Panel Petugas Pengelola Layanan Desa
                </p>
            </div>
        </div>

        <!-- Alert Error / Success -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs font-semibold">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-xs font-semibold">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="<?= base_url('admin/login') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>

            <div class="space-y-1">
                <label for="login" class="text-[11px] font-bold uppercase tracking-wider text-slate-600 block">Username / Email</label>
                <div class="relative">
                    <input type="text" id="login" name="login" value="<?= old('login') ?>" required autofocus
                           placeholder="admin@desentra.id"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal focus:bg-white transition-all shadow-xs">
                </div>
            </div>

            <div class="space-y-1">
                <label for="password" class="text-[11px] font-bold uppercase tracking-wider text-slate-600 block">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                           placeholder="••••••••"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-desentra-teal focus:bg-white transition-all shadow-xs">
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-3 rounded-full bg-gradient-to-r from-desentra-teal to-[#009E94] text-white font-extrabold text-xs shadow-md shadow-desentra-teal/25 hover:opacity-95 active:scale-[0.98] transition-all">
                Masuk ke Panel Admin →
            </button>
        </form>

        <!-- Quick 1-Click Demo Login Shortcuts -->
        <div class="pt-2 border-t border-slate-100 space-y-2">
            <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider text-center">Akun Uji Coba Cepat:</span>
            
            <div class="grid grid-cols-3 gap-1.5 text-center">
                <button type="button" onclick="fillCreds('admin', 'admin123')" 
                        class="p-2 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-200 text-purple-700 text-[10px] font-bold transition-colors">
                    Admin
                </button>
                <button type="button" onclick="fillCreds('editor', 'editor123')" 
                        class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 text-[10px] font-bold transition-colors">
                    Editor
                </button>
                <button type="button" onclick="fillCreds('verifikator', 'verifikator123')" 
                        class="p-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-700 text-[10px] font-bold transition-colors">
                    Verifikator
                </button>
            </div>
        </div>

        <!-- Footer Back Link -->
        <div class="text-center pt-2">
            <a href="<?= base_url('/') ?>" class="text-xs font-bold text-slate-500 hover:text-desentra-teal transition-colors">
                ← Kembali ke Portal Warga
            </a>
        </div>

    </div>

    <script>
        function fillCreds(login, pass) {
            document.getElementById('login').value = login;
            document.getElementById('password').value = pass;
        }
    </script>
</body>
</html>
