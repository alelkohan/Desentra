# PRODUCT REQUIREMENTS DOCUMENT (PRD): DESENTRA

**Versi:** 2.0 (revisi berdasarkan wireframe UI/UX)  
**Status:** Draft untuk validasi dan pengembangan MVP  
**Konteks:** Web Development Competition UINIC 8.0

## 1. Ringkasan Produk

**Desentra** (gabungan *desa* + *sentra*) adalah platform web mobile-first dan Progressive Web App (PWA) sebagai pusat layanan dan informasi masyarakat desa. Desentra menggabungkan panduan administrasi, tanya-jawab AI berbasis sumber desa, informasi desa, serta kanal pengaduan/masukan.

**Tagline:** *Panduan layanan desa yang mudah dipahami.*

**Tujuan MVP:** memudahkan warga di satu desa percontohan untuk menemukan informasi layanan, memahami persyaratan, menyiapkan dokumen, mengetahui informasi desa terkini, dan menyampaikan pengaduan/masukan tanpa diwajibkan membuat akun.

**Prinsip produk:**
- Informasi yang ditampilkan kepada warga bersumber jelas dan dikelola admin desa.
- AI membantu menemukan dan menjelaskan informasi; AI bukan pengambil keputusan atau sumber resmi.
- Warga dapat menggunakan fitur utama sebagai tamu. Login warga bersifat opsional.
- Informasi umum dapat dibaca di layar ponsel dan sebagian panduan dapat tersedia saat offline.

## 2. Pengguna dan Hak Akses

### 2.1 Warga (tamu atau akun opsional)

Warga **tidak wajib login**. Tanpa akun, warga dapat:
- Membuka Beranda, Layanan, Info Desa, dan Tanya AI.
- Membuat checklist yang disimpan di perangkat.
- Mengirim pengaduan/masukan dan menerima kode tiket untuk melihat statusnya kembali.
- Memberi umpan balik atas panduan atau jawaban AI.

Warga yang memilih membuat akun dapat menyinkronkan checklist, menyimpan panduan favorit/riwayat, dan melihat tiket pengaduan dari profil. Akun tidak membuktikan identitas atau domisili warga. Desentra tidak meminta NIK untuk fitur informasi umum. Penggunaan fitur utama tetap tersedia tanpa akun.

### 2.2 Admin Editor (login wajib)

- Membuat dan mengubah draf panduan, FAQ, serta Info Desa.
- Meninjau daftar pertanyaan yang belum terjawab dan antrean pengaduan.
- Tidak dapat menerbitkan konten kecuali juga memiliki kewenangan verifikator.

### 2.3 Admin Verifikator (login wajib)

- Memeriksa isi, sumber, dan tanggal peninjauan.
- Memverifikasi dan menerbitkan panduan, FAQ, atau informasi desa.
- Menandai konten yang perlu diperbarui.

Satu orang dapat memiliki kedua peran jika ditetapkan pengelola. Setiap admin menggunakan akun pribadi agar aktivitas dapat diaudit.

## 3. Tech Stack dan Arsitektur

- **Backend dan REST API:** CodeIgniter 4.
- **Database relasional:** MySQL.
- **UI:** HTML/PHP Views dengan Tailwind CSS, responsif dan mobile-first.
- **PWA:** Web App Manifest dan Service Worker.
- **Pertukaran data:** JSON untuk API; `multipart/form-data` untuk unggahan berkas.
- **AI:** dipanggil dari backend CI4. API key hanya disimpan di konfigurasi server (`.env`), tidak dikirim ke browser.
- **Autentikasi admin/warga opsional:** gunakan sesi server dan kontrol peran; lindungi aksi berbasis sesi dengan CSRF. API publik dan API tulis harus memiliki aturan akses yang berbeda.

Alur umum: `Browser → REST API CI4 → MySQL`. Untuk Tanya AI: `Pertanyaan → pencarian sumber terbit → AI → jawaban dan sitasi`.

## 4. Navigasi dan Acuan UI/UX

Wireframe pengguna menjadi acuan struktur dan navigasi. Referensi gambar kedua digunakan untuk **hierarki/layout beranda** (sapaan, judul utama, dan kartu-kartu bertingkat), bukan untuk menyalin konten aplikasi kesehatan.

### Navigasi utama mobile

Bottom navigation terdiri atas lima menu:
1. **Beranda**
2. **Info Desa**
3. **Tanya**
4. **Pengaduan**
5. **Layanan**

### Beranda

- Identitas Desentra dan pencarian.
- Nama/area desa percontohan sebagai teks yang dapat dikonfigurasi.
- Sapaan netral untuk tamu (contoh: “Halo, warga desa”) dan sapaan personal bila warga login.
- Kartu nilai utama sesuai wireframe: **Mudah**, **Aman**, serta kartu lebar **Up to date & transparan**.
- Kartu tersebut menjelaskan kemudahan menemukan informasi, sumber panduan yang jelas, dan tanggal pembaruan; tidak menyiratkan transparansi anggaran.
- Akses cepat ke layanan populer, pengumuman terbaru, Tanya AI, dan pengaduan.
- Ikon pencarian/notifikasi dapat digunakan tanpa memaksa login.

### Layanan

- Daftar kartu layanan seperti SKTM, Akta Kelahiran, dan Surat Rekomendasi.
- Kartu menampilkan ringkasan dan tombol **Lihat**.
- Halaman detail berisi persyaratan, langkah, FAQ terkait, sumber, tanggal diperiksa, dan tombol **Buat checklist**.

### Tanya (AI)

- Antarmuka percakapan sederhana sesuai wireframe.
- Pesan sambutan dan saran pertanyaan cepat (contoh: “Urus SKTM”, “Buat KTP”).
- Input pertanyaan dan tombol kirim.
- Jawaban menunjukkan referensi sumber serta tanggal pembaruannya.
- Pesan fallback mengarahkan warga ke kontak resmi apabila sumber tidak cukup.

### Info Desa

- Feed/kartu pengumuman, jadwal operasional, agenda, dan informasi penting.
- Konten dapat ditampilkan sebagai kartu utama dan daftar/kartu lain yang dapat digeser sesuai wireframe.
- Setiap kartu menampilkan tanggal dan masa berlaku; konten kedaluwarsa tidak ditampilkan sebagai informasi terbaru.

### Pengaduan

- Formulir sesuai wireframe dengan judul pengaduan, deskripsi, dokumentasi foto, dan tombol **Kirim Pengaduan**.
- Pengaduan dapat dikirim sebagai tamu; sistem memberi kode tiket unik untuk pengecekan status.
- Login opsional membuat tiket dapat dilihat dari akun.
- Formulir bukan pelaporan GIS: koordinat/peta otomatis tidak termasuk MVP.

> **Palet warna wajib** (atur sebagai token di `tailwind.config.js`):  
> - `orange #F08F0E` (aksen/background utama)  
> - `gold #F1B435` (highlight)  
> - `teal #008683` (latar utama)  
> - `turquoise #00B6AA` (aksen/tombol/ikon)  
> - `blue #3C7087` (kartu fitur)  
> - `blue-dark #1469A5` (aksen biru)  
> - `white #FFFFFF` (kartu/teks)  
> - `dark #131313` (teks utama)  
> - `mint-light #9ECECA` (aksen lembut)  
> **Logo belum menjadi bagian revisi ini** dan akan ditentukan terpisah.

## 5. Fitur MVP

### 5.1 Modul Layanan

**Warga:**
- Jelajah dan pencarian panduan.
- Detail syarat dan langkah.
- FAQ terverifikasi.
- Chat Q&A berbasis AI dengan sumber.
- Checklist syarat.
- Umpan balik konten/jawaban.

**Admin:**
- CRUD panduan, FAQ, persyaratan, dan sumber.
- Alur verifikasi/publikasi.
- Antrean pertanyaan yang tidak dapat dijawab AI.
- Riwayat perubahan admin.

### 5.2 Modul Info Desa

**Warga:**
- Membaca pengumuman, jadwal operasional, agenda, dan kontak.
- Melihat informasi penting yang masih berlaku.

**Admin:**
- CRUD konten Info Desa.
- Mengatur tanggal terbit dan tanggal kedaluwarsa.
- Menandai prioritas dan mengarsipkan informasi.

### 5.3 Modul Pengaduan

**Warga:**
- Mengirim judul, deskripsi, kategori, dan foto pendukung.
- Mendapat kode tiket.
- Mengecek status tiket menggunakan kode tiket; warga login dapat melihat tiketnya dari profil.
- Kontak balasan bersifat opsional. Jika tidak diisi, warga tetap bisa melihat status tetapi tidak menerima balasan langsung.

**Admin:**
- Melihat antrean pengaduan dan lampiran yang berizin.
- Mengubah status: `Received` → `In Review` → `In Progress` → `Resolved` atau `Rejected`.
- Menambahkan catatan tindak lanjut internal dan pesan publik jika kontak warga tersedia.
- Mencatat petugas serta waktu perubahan status.

Pengaduan berbeda dari antrean **pertanyaan AI yang belum terjawab**. Antrean AI digunakan untuk memperbaiki panduan; pengaduan digunakan untuk menindaklanjuti laporan/masukan warga.

### 5.4 Akun dan checklist

- Akses panduan, FAQ, Info Desa, dan Tanya AI tidak mensyaratkan akun.
- Checklist tamu disimpan lokal pada perangkat.
- Jika warga login, checklist dapat disinkronkan ke server.
- Riwayat AI dan penyimpanan tiket ke akun hanya dilakukan untuk pengguna login; pertanyaan tamu yang masuk antrean disimpan seminimal mungkin dan tidak perlu memuat identitas.

## 6. Aturan AI (RAG)

- Sumber AI hanya panduan/FAQ berstatus `Published` dan terverifikasi.
- Backend mencari potongan sumber yang relevan sebelum memanggil model AI.
- Jawaban mencantumkan sumber yang benar-benar digunakan.
- Jika hasil pencarian tidak cukup relevan, backend mengembalikan fallback dan menaruh pertanyaan untuk ditinjau admin.
- AI tidak mengakses API/database pemerintah, tidak memutuskan kelayakan layanan, dan tidak boleh mengarang persyaratan.
- Isi dokumen sumber dan pertanyaan dianggap data, bukan instruksi untuk mengubah aturan sistem.
- Batasi panjang dan frekuensi pertanyaan. Beri peringatan agar warga tidak mengirim NIK atau data sensitif.

## 7. Status Konten dan Verifikasi

Status konten: `Draft` → `Pending Verification` → `Published`; konten terbit dapat menjadi `Needs Review` atau `Archived`.

- `Draft`: hanya dapat dilihat editor/admin; tidak tampil untuk warga/AI.
- `Pending Verification`: menunggu pemeriksaan verifikator.
- `Published`: sudah diperiksa, tampil untuk warga dan boleh menjadi sumber AI.
- `Needs Review`: perlu pemeriksaan ulang; hentikan penggunaan sebagai sumber AI sampai diverifikasi ulang.
- `Archived`: tidak tampil sebagai konten aktif.

Simpan sumber, tanggal pemeriksaan, pembuat, verifikator, dan waktu publikasi. Untuk Info Desa, tanggal kedaluwarsa juga wajib diatur.

## 8. PWA dan Offline

- Cache aset statis aplikasi.
- Cache hanya halaman/panduan publik yang memang telah dibuka atau dipilih untuk disimpan.
- Checklist tamu disimpan lokal; akun warga dapat melakukan sinkronisasi saat online.
- Chat AI, pengiriman pengaduan/umpan balik, perubahan admin, dan pembaruan data memerlukan koneksi.
- Jangan cache respons admin, data akun, chat privat, token, atau data sensitif.
- Tampilkan waktu terakhir panduan/info diperbarui dan indikator ketika pengguna sedang offline.

## 9. Keamanan dan Privasi

1. Minimalkan data: NIK tidak diperlukan untuk membaca informasi atau bertanya soal prosedur umum.
2. Admin wajib login; semua endpoint tulis admin memeriksa autentikasi dan peran di backend.
3. Terapkan CSRF untuk aksi berbasis sesi, validasi server-side, query terparameterisasi/Query Builder, dan output encoding untuk mencegah XSS.
4. Batasi login, Tanya AI, ukuran request, dan unggahan.
5. Unggahan dibatasi ke tipe/ukuran yang diperlukan, diberi nama acak, dan disimpan tanpa izin eksekusi; akses lampiran pengaduan dikontrol.
6. Simpan API key dan rahasia hanya di server. Gunakan HTTPS dan konfigurasi produksi tanpa debug.
7. Audit aksi admin (buat, ubah, verifikasi, terbit, ubah status tiket). Jangan log kata sandi, token, API key, NIK, atau isi sensitif mentah.
8. Tentukan masa retensi dan penghapusan untuk pertanyaan tamu, lampiran, serta tiket.
9. Siapkan backup MySQL dan prosedur pemulihan.

## 10. Struktur Database Konseptual

| Tabel | Isi/relasi utama |
|---|---|
| `ADMIN_USERS` | Akun admin, status, peran editor/verifikator. |
| `RESIDENT_USERS` | Akun warga opsional; tidak memuat NIK. |
| `SERVICE_GUIDES` | Panduan, status, pembuat, verifikator, waktu terbit. |
| `CONTENT_SOURCES` | URL/dokumen sumber, penerbit, tanggal pemeriksaan. |
| `GUIDE_SOURCES` | Relasi panduan dengan satu atau lebih sumber. |
| `GUIDE_REQUIREMENTS` | Item persyaratan per panduan. |
| `FAQS` | Tanya-jawab, status, pembuat, verifikator. |
| `FAQ_SOURCES` | Relasi FAQ dengan sumber. |
| `GUIDE_CHUNKS` | Potongan teks panduan untuk pencarian RAG. |
| `RESIDENT_QUESTIONS` | Pertanyaan tamu/akun, status jawaban, masa retensi. |
| `QUESTION_SOURCES` | Sumber chunk/FAQ yang digunakan untuk jawaban. |
| `QUESTION_FEEDBACK` | Rating/masukan atas jawaban atau panduan. |
| `VILLAGE_INFOS` | Pengumuman, jadwal, agenda, tanggal berlaku, status. |
| `COMPLAINTS` | Tiket, kategori, judul, deskripsi, status, kode tiket, pemilik opsional. |
| `COMPLAINT_ATTACHMENTS` | Metadata/lokasi penyimpanan foto dengan akses terkontrol. |
| `COMPLAINT_STATUS_HISTORY` | Status, catatan publik/internal, petugas, waktu. |
| `RESIDENT_CHECKLISTS` | Checklist milik akun warga yang memilih login/sinkronisasi. |
| `RESIDENT_CHECKLIST_ITEMS` | Status tiap syarat checklist tersinkron. |
| `ADMIN_AUDIT_LOGS` | Admin, aksi, entitas, waktu, dan perubahan relevan. |

Checklist tamu tetap lokal dan tidak dibuatkan data server. Tetapkan foreign key, unique constraint, indeks, dan aturan delete/retensi saat membuat migration.

## 11. Batasan MVP

**Termasuk:** satu desa percontohan; panduan dan FAQ; tanya AI berbasis sumber; checklist lokal dan sinkronisasi untuk akun opsional bila waktu memungkinkan; Info Desa; pengaduan tanpa GIS; dasbor admin; REST API; PWA offline terbatas.

**Di luar lingkup:** integrasi API resmi pemerintah, peta/koordinat GIS, status real-time dari sistem instansi, transparansi anggaran terperinci, broadcast darurat, pembuatan dokumen otomatis, dan verifikasi identitas kependudukan.

Data yang tidak terhubung ke instansi harus diberi label demo/simulasi. Kontak dan sumber desa percontohan harus diverifikasi sebelum publikasi.

## 12. Kriteria Keberhasilan MVP

- Warga dapat menemukan panduan dan memahami langkahnya melalui uji pengguna.
- Jawaban AI menampilkan sumber yang sesuai atau melakukan fallback saat sumber tidak cukup.
- Admin dapat membuat, memverifikasi, menerbitkan, dan mengarsipkan konten.
- Warga dapat mengirim pengaduan, menerima kode tiket, dan melihat status awal.
- Panduan yang telah dibuka dapat dibaca offline; fitur online memberi indikator koneksi.
- Hak akses admin, validasi input, unggahan, dan penyimpanan rahasia ditunjukkan pada demo.

## 13. Kebutuhan Proposal Lomba

Proposal mengikuti template resmi UINIC 8.0, berbahasa Indonesia, maksimal 30 halaman di luar lampiran, dan mencakup identitas peserta, judul, latar belakang, tujuan/manfaat, target pengguna, batasan produk, stack, metodologi, arsitektur, skenario, user flow, fitur, UI/UX, pengujian pengguna jika tersedia, kesimpulan, serta sumber/lampiran. Sertakan tautan demo online dan repository yang dapat diakses juri beserta dokumentasi/panduan penggunaan.

## 14. Prioritas Implementasi

1. Inisialisasi CI4, MySQL migrations, autentikasi admin, dan layout Tailwind mengikuti wireframe/palet warna.
2. CRUD panduan, sumber, persyaratan, FAQ, dan alur verifikasi.
3. Halaman warga: Beranda, Layanan, Info Desa.
4. REST API dan Tanya AI dengan pencarian sumber, sitasi, fallback, serta rate limit.
5. Pengaduan, kode tiket, antrean admin, dan status.
6. PWA/cache publik dan checklist lokal; sinkronisasi akun warga jika waktu MVP mencukupi.
7. Dokumentasi, demo online, dan uji pengguna.

## 15. Aturan Standar Desain, UI/UX, Teknis, dan Protokol Alur Kerja

Bagian ini merangkum aturan tetap dan batasan implementasi yang wajib dipatuhi selama proses pengembangan Desentra:

### 15.1 Aturan Estetika & Desain Visual (BSI Design System & Mobile-First)
- **Mobile-First Viewport**: Antarmuka diutamakan untuk tampilan layar ponsel (`max-w-md mx-auto`), responsif, dan siap Progressive Web App (PWA).
- **Palet Warna Acuan (Aplikasi Mobile Banking BSI)**:
  - `Teal` (`#008683`): Warna primer institusional (latar utama, kartu aktif, tombol primer).
  - `Turquoise` (`#00B6AA` / `#009E94`): Aksen tombol, active tabs, gradien pendukung.
  - `Orange` (`#F08F0E`): Aksen badge, kategori pengumuman penting, highlight interaktif.
  - `Gold` (`#F1B435`): Highlight bintang dan aksen sekunder.
  - `Dark / Slate` (`#131313` / Slate 50–900): Tipografi modern netral.
- **Standar Estetika Visual**: Dilarang menggunakan warna generik mentah (plain red/blue). Desain wajib terasa premium, rapi, bersih, memiliki *micro-animations* yang halus, dan tidak berkesan seperti MVP mentah.

### 15.2 Aturan Dialog & Konfirmasi Interaktif (Bottom Sheet)
- **Penerapan Bottom Sheet**: Untuk saat ini, seluruh dialog konfirmasi interaktif di sisi warga (misalnya: submit checklist, kirim pengaduan, konfirmasi aksi penting) **wajib menggunakan Bottom Sheet** (muncul *slide-up* dari bawah layar ponsel), karena saat ini **belum dibuat desktop view-nya**.
- **Larangan**: Dilarang menggunakan `alert()` / `confirm()` bawaan browser dan dilarang menggunakan pop-up modal kotak desktop di tengah layar.

### 15.3 Aturan Teknis, Lingkungan, Keamanan Berkas, & Repositori Git
- **Tech Stack & Server Lokal**: CodeIgniter 4 (PHP 8.3), MySQL 8.4, Tailwind CSS 3.4. Server lokal dijalankan melalui Spark port 8080 (`php spark serve --port 8080`) dan MySQL server port 3306.
- **Keamanan Berkas (.gitignore & .env)**:
  - Berkas `.env` asli dan kredensial rahasia (Gemini API Key, kata sandi database, encryption key) **wajib diabaikan oleh Git** (`.gitignore`).
  - Berkas `.env.example` disediakan sebagai acuan konfigurasi tanpa memuat nilai rahasia.
  - Direktori `node_modules/`, `writable/session/*`, `writable/logs/*`, dan `writable/debugbar/*` wajib masuk `.gitignore`.
- **Repositori Git Resmi**: `https://github.com/alelkohan/Desentra.git` (Branch utama: `main`).

### 15.4 Protokol Alur Kerja & Komunikasi Pengembangan (Workflow Protocol)
- **Klarifikasi Sebelum Eksekusi**: Ketika pengguna menginstruksikan sesuatu dengan pertanyaan/arahan seperti *"paham ngga? jelasin dulu"* atau *"jawab dulu jangan dibuat dulu"*:
  - **Wajib**: Jelaskan pemahaman logika, rancangan, dan mekanismenya terlebih dahulu secara transparan.
  - **Larangan**: Jangan langsung menulis atau mengubah kode sebelum pengguna memberikan konfirmasi lanjutan (*"gaskan / lanjut"*).
