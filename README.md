# Desentra (Desa + Sentra) 🌾🏛️

[![CodeIgniter 4](https://img.shields.io/badge/Framework-CodeIgniter%204.7-EF5350?style=for-the-badge&logo=codeigniter&logoColor=white)](https://codeigniter.com/)
[![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![PWA Ready](https://img.shields.io/badge/PWA-Ready-5A0FC8?style=for-the-badge&logo=pwa&logoColor=white)](https://web.dev/progressive-web-apps/)

> **Tagline:** *Panduan Layanan Desa yang Mudah Dipahami.*  
> **Konteks:** Dikembangkan untuk *Web Development Competition UINIC 8.0*.

---

## 📌 Tentang Desentra

**Desentra** (*Desa + Sentra*) adalah platform web *mobile-first* dan Progressive Web App (PWA) yang dirancang sebagai pusat integrasi layanan administrasi, keterbukaan informasi, dan komunikasi masyarakat desa.

Desentra mengutamakan kemudahan akses bagi seluruh lapisan warga:
* **Tanpa Wajib Login**: Warga tamu dapat langsung menelusuri persyaratan, menyusun checklist berkas, membaca kabar desa, dan melayangkan pengaduan menggunakan kode tiket unik.
* **AI-Powered Consultation**: Fitur konsultasi cerdas berbasis Google Gemini yang menjawab prosedur layanan desa secara akurat bersumber dari dokumen resmi desa.
* **Aethetics & UX Terkurasi**: Mengusung palet warna institusional modern (Teal, Turquoise, Orange, Gold) terinspirasi standar aplikasi perbankan nasional, navigasi Bottom Sheet yang responsif, dan interaksi sentuh *cover-flow*.

---

## ✨ Fitur Utama

### 📱 1. Sisi Warga (Mobile-First Experience)
* **Beranda Pintar**:
  * Akses cepat layanan populer, pengumuman darurat, dan ringkasan agenda.
  * Kartu nilai transparansi dan kontak operasional resmi desa.
* **Katalog & Panduan Layanan Administrasi**:
  * Rincian persyaratan, alur langkah, estimasi waktu, dan FAQ (SKTM, KTP, KK, Akta, Surat Pindah, dll).
  * **Interactive Checklist**: Ceklis dokumen persyaratan yang tersimpan otomatis di perangkat warga (*localStorage*).
* **Info Desa & Kabar Terkini**:
  * **3D Cover-Flow Carousel**: Menampilkan 4 kabar terbaru desa secara dinamis dengan navigasi sentuh (*swipe/drag*) tanpa looping.
  * **Filter Kategori Instan**: Menyaring arsip berita (Pengumuman, Jadwal Layanan, Agenda, Penting) tanpa perlu memuat ulang seluruh halaman.
* **Tanya AI (Desentra Assistant)**:
  * Konsultasi birokrasi 24/7 menggunakan kecerdasan buatan (*Google Gemini API*) yang dipadukan dengan referensi panduan resmi desa.
* **Kanal Aspirasi & Pengaduan**:
  * Formulir pelaporan warga dengan lampiran bukti foto.
  * Pelacakan status laporan secara mandiri menggunakan kode tiket unik (*Tracking ID*).

### 🖥️ 2. Portal Admin & Pengelola Desa
* **Dashboard Statistik**: Pemantauan jumlah panduan, informasi aktif, dan antrean pengaduan secara terpusat.
* **Manajemen Info Desa**: CRUD informasi desa, upload poster/banner, tanggal kedaluwarsa otomatis, dan arsip.
* **Manajemen Layanan & Dokumen**: Pengelolaan syarat, alur langkah, dan basis data pengetahuan untuk AI.
* **Tindak Lanjut Pengaduan**: Workflow verifikasi status pengaduan (*Received* → *In Review* → *In Progress* → *Resolved* / *Rejected*) disertai catatan tindak lanjut petugas.
* **Audit Trail**: Pencatatan aktivitas pembuatan dan pembaruan data untuk akuntabilitas aparatur desa.

---

## 🛠️ Tech Stack & Arsitektur

| Komponen | Teknologi |
| :--- | :--- |
| **Backend Framework** | [CodeIgniter 4](https://codeigniter.com/) (PHP 8.3+) |
| **Arsitektur** | Model-View-Controller (MVC) & Clean Service Layer |
| **Styling & UI** | [Tailwind CSS 3.4](https://tailwindcss.com/) & Vanilla CSS Micro-interactions |
| **Database** | MySQL 8.4 |
| **AI Integration** | Google Gemini 1.5 Flash API (Server-side Secure Proxy) |
| **PWA** | Web App Manifest & Service Worker Caching |
| **Environment** | Laragon / Apache / Nginx |

---

## 🎨 Palet Warna Desentra

Desentra dirancang dengan palet warna elegan yang memberi kesan ramah, amanah, dan terpercaya:

* `desentra-teal` (`#008683`): Warna primer (kewibawaan, stabilitas, dan keterbukaan).
* `desentra-turquoise` (`#00B6AA`): Aksen modern, tombol aktif, dan gradien pendukung.
* `desentra-orange` (`#F08F0E`): Aksen peringatan, kategori sorotan, dan aksi interaktif.
* `desentra-gold` (`#F1B435`): Highlight bintang dan elemen prioritas.
* `desentra-blue` (`#3C7087`): Latar kartu informasi pelengkap.

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat Sistem
* PHP 8.2 atau lebih tinggi (disarankan PHP 8.3)
  * Ekstensi PHP aktif: `intl`, `mbstring`, `mysqli`, `curl`, `json`
* MySQL 8.0+ atau MariaDB
* Node.js v18+ (opsional untuk memodifikasi styling Tailwind)

### 2. Clone Repositori
```bash
git clone https://github.com/alelkohan/Desentra.git
cd Desentra
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Sesuaikan konfigurasi database dan API Key di dalam `.env`:
```ini
database.default.hostname = 127.0.0.1
database.default.database = desentra
database.default.username = root
database.default.password = 
database.default.port     = 3306

# (Opsional) Google Gemini API Key untuk fitur Tanya AI
GEMINI_API_KEY = 'YOUR_GEMINI_API_KEY_HERE'
```

### 4. Migrasi & Seeding Database
Jalankan migrasi tabel dan data awal percontohan:
```bash
php spark migrate
php spark db:seed DesentraSeeder
```

### 5. Kompilasi Aset CSS (Opsional)
Jika Anda melakukan perubahan pada konfigurasi styling Tailwind:
```bash
npm install
npm run build:css
```

### 6. Jalankan Server Lokal
```bash
php spark serve --port 8080
```
Buka browser dan akses:
* **Halaman Warga**: [http://localhost:8080](http://localhost:8080)
* **Portal Admin**: [http://localhost:8080/admin/login](http://localhost:8080/admin/login)

---

## 🔐 Kredensial Akun Default

Untuk keperluan demonstrasi dan peninjauan juri:

| Role | Username | Password |
| :--- | :--- | :--- |
| **Super Admin / Editor** | `admin` | `admin123` |

---

## 📁 Struktur Direktori

```text
desentra/
├── app/
│   ├── Config/           # Konfigurasi aplikasi & database
│   ├── Controllers/      # Controller Warga & Admin (Auth, Layanan, InfoDesa, dll)
│   ├── Database/         # Migrations & Seeders
│   ├── Models/           # Model data relasional
│   └── Views/
│       ├── admin/        # Tampilan portal manajemen admin
│       ├── layouts/      # Layout utama (mobile frame & navbar)
│       └── warga/        # Tampilan muka aplikasi warga
├── public/               # Web root (index.php, CSS, PWA manifest, aset gambar)
├── src/                  # Sumber CSS input untuk Tailwind
├── writable/             # Cache, sesi, log, dan folder sementara
├── spark                 # CLI tool CodeIgniter 4
└── PRD.md                # Dokumen spesifikasi kebutuhan produk
```

---

## 📄 Lisensi & Hak Cipta

Proyek ini dikembangkan secara terbuka untuk ajang **Web Development Competition UINIC 8.0**.  
Hak cipta dilindungi undang-undang © 2026 **Tim Desentra**.
