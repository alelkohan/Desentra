<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DesentraSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 1. ADMIN USERS
        $adminUsers = [
            [
                'username'      => 'admin',
                'email'         => 'admin@desentra.id',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'full_name'     => 'Ahmad Fauzi (Administrator)',
                'role'          => 'admin',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'editor',
                'email'         => 'editor@desentra.id',
                'password_hash' => password_hash('editor123', PASSWORD_BCRYPT),
                'full_name'     => 'Siti Rahmawati (Admin Editor)',
                'role'          => 'editor',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'verifikator',
                'email'         => 'verifikator@desentra.id',
                'password_hash' => password_hash('verifikator123', PASSWORD_BCRYPT),
                'full_name'     => 'Bambang Hartono (Admin Verifikator)',
                'role'          => 'verifier',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('admin_users')->ignore(true)->insertBatch($adminUsers);

        // 2. CONTENT SOURCES
        $sources = [
            [
                'title'        => 'Peraturan Bupati Bogor No. 45 Tahun 2021 tentang Pedoman Pelayanan Desa',
                'url'          => 'https://jdih.bogorkab.go.id/perbup-45-2021',
                'publisher'    => 'Bagian Hukum Setda Kab. Bogor',
                'checked_date' => date('Y-m-d', strtotime('-10 days')),
                'notes'        => 'Sumber resmi rujukan penerbitan SKTM dan surat pengantar desa.',
                'created_by'   => 1,
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'title'        => 'SOP Pelayanan Kantor Desa Sukamaju Tahun 2026',
                'url'          => 'https://sukamaju.desa.id/dokumen/sop-2026',
                'publisher'    => 'Pemerintah Desa Sukamaju',
                'checked_date' => date('Y-m-d', strtotime('-5 days')),
                'notes'        => 'Standar operasional prosedur jam layanan dan kelengkapan berkas.',
                'created_by'   => 1,
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'title'        => 'Permendagri No. 108 Tahun 2019 tentang Pelaksanaan Perpres Administrasi Kependudukan',
                'url'          => 'https://peraturan.go.id/id/permendagri-no-108-tahun-2019',
                'publisher'    => 'Kementerian Dalam Negeri Republik Indonesia',
                'checked_date' => date('Y-m-d', strtotime('-15 days')),
                'notes'        => 'Dasar hukum penerbitan Akta Kelahiran dan KTP-el.',
                'created_by'   => 1,
                'created_at'   => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('content_sources')->ignore(true)->insertBatch($sources);

        // 3. SERVICE GUIDES
        $guides = [
            [
                'id'                 => 1,
                'slug'               => 'sktm',
                'title'              => 'Surat Keterangan Tidak Mampu (SKTM)',
                'category'           => 'Sosial & Bantuan',
                'summary'            => 'Layanan permohonan SKTM untuk keperluan beasiswa pendidikan, keringanan biaya rumah sakit, atau bantuan sosial pemerintah.',
                'description'        => 'Surat Keterangan Tidak Mampu (SKTM) diterbitkan oleh Pemerintah Desa untuk menyatakan bahwa pemohon benar-benar warga prasejahtera. Surat ini dapat digunakan untuk pendaftaran beasiswa (KIP-Kuliah), program BPJS PBI, serta keringanan rumah sakit.',
                'steps_json'         => json_encode([
                    'Minta surat pengantar dari Ketua RT dan RW setempat.',
                    'Bawa seluruh dokumen persyaratan ke loket Pelayanan Umum Kantor Desa Sukamaju.',
                    'Petugas desa akan memverifikasi berkas dan mencocokkan data kependudukan.',
                    'Kepala Seksi Kesejahteraan Desa menandatangani draf verifikasi SKTM.',
                    'Kepala Desa / Sekretaris Desa menandatangani dan membubuhi stempel dinas.',
                    'Ambil surat fisik atau mintakan scan digital yang telah dilegalisir.'
                ]),
                'estimated_duration' => '15 - 30 Menit (Bila berkas lengkap)',
                'fee_description'    => 'Gratis (Rp 0)',
                'icon'               => 'academic-cap',
                'status'             => 'published',
                'created_by'         => 2,
                'verified_by'        => 3,
                'checked_at'         => date('Y-m-d H:i:s', strtotime('-2 days')),
                'published_at'       => date('Y-m-d H:i:s', strtotime('-2 days')),
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'id'                 => 2,
                'slug'               => 'akta-kelahiran',
                'title'              => 'Surat Pengantar Akta Kelahiran',
                'category'           => 'Kependudukan',
                'summary'            => 'Pengantar administrasi desa untuk penerbitan kutipan akta kelahiran bagi anak baru lahir.',
                'description'        => 'Surat pengantar ini digunakan untuk melengkapi pengajuan Kutipan Akta Kelahiran ke Disdukcapil. Pengajuan disarankan dilakukan maksimal 60 hari sejak hari kelahiran anak.',
                'steps_json'         => json_encode([
                    'Siapkan Surat Keterangan Lahir asli dari Bidan, Rumah Sakit, atau Puskesmas.',
                    'Lengkapi fotokopi Buku Nikah orang tua yang dilegalisir KUA.',
                    'Datang ke loket Pelayanan Kependudukan Kantor Desa Sukamaju.',
                    'Petugas akan memvalidasi data KK dan mencetak Formulir F-2.01 beserta Surat Pengantar.',
                    'Surat disahkan oleh Pejabat Desa untuk diteruskan ke Disdukcapil / aplikasi kependudukan online.'
                ]),
                'estimated_duration' => '20 Menit',
                'fee_description'    => 'Gratis (Rp 0)',
                'icon'               => 'user-group',
                'status'             => 'published',
                'created_by'         => 2,
                'verified_by'        => 3,
                'checked_at'         => date('Y-m-d H:i:s', strtotime('-3 days')),
                'published_at'       => date('Y-m-d H:i:s', strtotime('-3 days')),
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'id'                 => 3,
                'slug'               => 'ktp-el-kk',
                'title'              => 'Pengantar KTP-el & Pembaruan KK',
                'category'           => 'Kependudukan',
                'summary'            => 'Surat pengantar untuk perekaman e-KTP pemula (usia 17 tahun), pergantian KTP rusak/hilang, dan pembaruan susunan Kartu Keluarga.',
                'description'        => 'Layanan ini membantu warga Desa Sukamaju mendapatkan rekomendasi pengantar resmi untuk rekam KTP elektronik di Kantor Kecamatan Ciawi atau pencetakan ulang KK baru.',
                'steps_json'         => json_encode([
                    'Bawa Fotokopi Kartu Keluarga terbaru.',
                    'Bagi KTP hilang: lampirkan Surat Tanda Lapor Kehilangan (STLK) dari Polsek setempat.',
                    'Bagi KTP rusak: bawa fisik KTP lama yang rusak.',
                    'Petugas desa memeriksa NIK di database kependudukan.',
                    'Cetak Surat Pengantar Perekaman/Pencetakan untuk dibawa ke Kantor Kecamatan.'
                ]),
                'estimated_duration' => '15 Menit',
                'fee_description'    => 'Gratis (Rp 0)',
                'icon'               => 'identification',
                'status'             => 'published',
                'created_by'         => 2,
                'verified_by'        => 3,
                'checked_at'         => date('Y-m-d H:i:s', strtotime('-1 days')),
                'published_at'       => date('Y-m-d H:i:s', strtotime('-1 days')),
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'id'                 => 4,
                'slug'               => 'skdu',
                'title'              => 'Surat Keterangan Domisili Usaha (SKDU)',
                'category'           => 'Ekonomi & Usaha',
                'summary'            => 'Keterangan izin domisili bagi UMKM, toko kelontong, atau usaha mikro warga di wilayah desa.',
                'description'        => 'Diberikan kepada warga yang memiliki usaha mikro/kecil aktif di desa untuk kelengkapan pembukaan rekening bank usaha atau pengajuan bantuan permodalan UMKM.',
                'steps_json'         => json_encode([
                    'Minta surat pengantar RT/RW setempat yang menyatakan lokasi usaha aktif.',
                    'Foto tempat usaha/kegiatan produksi tampak depan.',
                    'Bawa fotokopi KTP dan KK pemilik usaha ke Kantor Desa.',
                    'Pengecekan kesesuaian zonasi lingkungan oleh Kasi Pemerintahan Desa.',
                    'Penerbitan Surat Keterangan Domisili Usaha bertandatangan Kepala Desa.'
                ]),
                'estimated_duration' => '1 Hari Kerja',
                'fee_description'    => 'Gratis (Rp 0)',
                'icon'               => 'building-storefront',
                'status'             => 'published',
                'created_by'         => 2,
                'verified_by'        => 3,
                'checked_at'         => date('Y-m-d H:i:s', strtotime('-4 days')),
                'published_at'       => date('Y-m-d H:i:s', strtotime('-4 days')),
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('service_guides')->ignore(true)->insertBatch($guides);

        // 4. GUIDE REQUIREMENTS
        $requirements = [
            // SKTM (guide_id: 1)
            ['guide_id' => 1, 'title' => 'Surat Pengantar RT/RW setempat', 'description' => 'Asli, ditandatangani Ketua RT dan RW dengan cap stempel', 'is_mandatory' => 1, 'order_position' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 1, 'title' => 'Fotokopi Kartu Keluarga (KK)', 'description' => '1 lembar KK terbaru yang masih berlaku', 'is_mandatory' => 1, 'order_position' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 1, 'title' => 'Fotokopi KTP Pemohon / Orang Tua', 'description' => '1 lembar KTP pemohon atau kepala keluarga', 'is_mandatory' => 1, 'order_position' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 1, 'title' => 'Surat Pernyataan Tidak Mampu bermaterai', 'description' => 'Materai Rp 10.000 ditandatangani kepala keluarga (format tersedia di kantor desa)', 'is_mandatory' => 1, 'order_position' => 4, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 1, 'title' => 'Foto Rumah Tampak Depan', 'description' => 'Khusus pengajuan beasiswa KIP-K atau bantuan bedah rumah', 'is_mandatory' => 0, 'order_position' => 5, 'created_at' => date('Y-m-d H:i:s')],

            // Akta Kelahiran (guide_id: 2)
            ['guide_id' => 2, 'title' => 'Surat Keterangan Kelahiran Asli', 'description' => 'Dari Bidan, Klinik, Puskesmas, atau Dokter', 'is_mandatory' => 1, 'order_position' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 2, 'title' => 'Fotokopi Buku Nikah / Akta Perkawinan', 'description' => 'Dilegalisir KUA setempat', 'is_mandatory' => 1, 'order_position' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 2, 'title' => 'Fotokopi KTP Kedua Orang Tua & 2 Saksi', 'description' => 'KTP ayah, ibu, dan 2 saksi warga setempat', 'is_mandatory' => 1, 'order_position' => 3, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 2, 'title' => 'Fotokopi Kartu Keluarga (KK)', 'description' => 'KK orang tua yang terdaftar di Desa Sukamaju', 'is_mandatory' => 1, 'order_position' => 4, 'created_at' => date('Y-m-d H:i:s')],

            // KTP & KK (guide_id: 3)
            ['guide_id' => 3, 'title' => 'Fotokopi Kartu Keluarga (KK)', 'description' => 'Wajib dibawa untuk pencocokan NIK', 'is_mandatory' => 1, 'order_position' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 3, 'title' => 'Fotokopi Akta Kelahiran / Ijazah', 'description' => 'Untuk verifikasi tanggal lahir dan nama lengkap pemula', 'is_mandatory' => 1, 'order_position' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 3, 'title' => 'KTP Lama (Jika rusak) atau Surat Kehilangan Polsek (Jika hilang)', 'description' => 'Hanya bagi permohonan penggantian KTP', 'is_mandatory' => 0, 'order_position' => 3, 'created_at' => date('Y-m-d H:i:s')],

            // SKDU (guide_id: 4)
            ['guide_id' => 4, 'title' => 'Surat Pengantar RT/RW', 'description' => 'Menyatakan benar ada aktivitas usaha di alamat tersebut', 'is_mandatory' => 1, 'order_position' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 4, 'title' => 'Fotokopi KTP & KK Pemilik Usaha', 'description' => 'Identitas sah pelaku usaha', 'is_mandatory' => 1, 'order_position' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['guide_id' => 4, 'title' => 'Foto Tempat Usaha / Produk', 'description' => '1 lembar foto kegiatan usaha tampak depan', 'is_mandatory' => 1, 'order_position' => 3, 'created_at' => date('Y-m-d H:i:s')],
        ];
        $db->table('guide_requirements')->ignore(true)->insertBatch($requirements);

        // 5. GUIDE SOURCES RELATIONS
        $guideSources = [
            ['guide_id' => 1, 'source_id' => 1, 'citation_note' => 'Pasal 12 ayat (2) kriteria surat keterangan kemiskinan desa'],
            ['guide_id' => 1, 'source_id' => 2, 'citation_note' => 'Standar Waktu Layanan SKTM 30 Menit'],
            ['guide_id' => 2, 'source_id' => 3, 'citation_note' => 'Pasal 27 batas pelaporan 60 hari kerja'],
            ['guide_id' => 3, 'source_id' => 3, 'citation_note' => 'Ketentuan penerbitan KTP-el pemula'],
            ['guide_id' => 4, 'source_id' => 2, 'citation_note' => 'SOP perizinan skala mikro desa'],
        ];
        $db->table('guide_sources')->ignore(true)->insertBatch($guideSources);

        // 6. FAQS
        $faqs = [
            [
                'id'               => 1,
                'service_guide_id' => 1,
                'question'         => 'Berapa biaya pengurusan SKTM di Desa Sukamaju?',
                'answer'           => 'Pengurusan SKTM di Desa Sukamaju sepenuhnya GRATIS (Rp 0). Apabila ada pungutan liar, warga berhak melaporkan melalui menu Pengaduan Desentra.',
                'category'         => 'Biaya Layanan',
                'status'           => 'published',
                'created_by'       => 2,
                'verified_by'      => 3,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'id'               => 2,
                'service_guide_id' => 1,
                'question'         => 'Apakah SKTM bisa diwakilkan orang lain?',
                'answer'           => 'Pengurusan SKTM dapat diwakilkan oleh anggota keluarga yang masih satu Kartu Keluarga (misal orang tua mengurus untuk anak). Jika diwakilkan oleh pihak di luar KK, wajib menyertakan Surat Kuasa bermaterai.',
                'category'         => 'Prosedur',
                'status'           => 'published',
                'created_by'       => 2,
                'verified_by'      => 3,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'id'               => 3,
                'service_guide_id' => 2,
                'question'         => 'Apakah bisa membuat akta kelahiran jika anak sudah berusia lebih dari 1 tahun?',
                'answer'           => 'Bisa. Pelaporan kelahiran yang melebihi batas 60 hari tetap dapat diproses melalui prosedur pencatatan terlambat di Disdukcapil dengan pengantar dari desa.',
                'category'         => 'Kependudukan',
                'status'           => 'published',
                'created_by'       => 2,
                'verified_by'      => 3,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
            [
                'id'               => 4,
                'service_guide_id' => null,
                'question'         => 'Kapan jam operasional loket pelayanan kantor desa?',
                'answer'           => 'Loket pelayanan Kantor Desa Sukamaju buka setiap hari Senin s/d Jumat, pukul 08:00 - 15:00 WIB (Istirahat pukul 12:00 - 13:00 WIB, hari Jumat pukul 11:30 - 13:00 WIB). Hari Sabtu, Minggu, dan Hari Libur Nasional tutup.',
                'category'         => 'Jadwal & Operasional',
                'status'           => 'published',
                'created_by'       => 2,
                'verified_by'      => 3,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('faqs')->ignore(true)->insertBatch($faqs);

        // 7. GUIDE CHUNKS (Untuk RAG AI Search)
        $chunks = [
            [
                'guide_id'    => 1,
                'faq_id'      => null,
                'title'       => 'SKTM - Syarat & Prosedur',
                'chunk_text'  => 'Surat Keterangan Tidak Mampu (SKTM) diterbitkan untuk keperluan beasiswa, BPJS PBI, atau keringanan rumah sakit. Biaya penerbitan adalah GRATIS. Persyaratan wajib meliputi: Surat Pengantar RT/RW setempat, Fotokopi Kartu Keluarga (KK), Fotokopi KTP pemohon, dan Surat Pernyataan Tidak Mampu bermaterai 10.000.',
                'keywords'    => 'sktm, tidak mampu, miskin, beasiswa, bpjs, biaya, gratis, syarat',
                'token_count' => 65,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'guide_id'    => 2,
                'faq_id'      => null,
                'title'       => 'Akta Kelahiran - Syarat & Langkah',
                'chunk_text'  => 'Pembuatan Surat Pengantar Akta Kelahiran di Desa Sukamaju bebas biaya (gratis). Warga wajib membawa: Surat Keterangan Lahir dari bidan/dokter/RS, fotokopi Buku Nikah orang tua dilegalisir KUA, fotokopi KK orang tua, dan fotokopi KTP orang tua serta 2 orang saksi.',
                'keywords'    => 'akta kelahiran, lahir, bayi, surat lahir, buku nikah, saksi, gratis',
                'token_count' => 60,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'guide_id'    => 3,
                'faq_id'      => null,
                'title'       => 'KTP Elektronik & KK - Perekaman Pemula dan Penggantian',
                'chunk_text'  => 'Pengantar pembuatan KTP-el dan perbaikan KK diterbitkan di loket kependudukan desa. Bagi warga usia 17 tahun, bawa fotokopi KK dan fotokopi Akta Lahir untuk mendapat pengantar rekam biometrik di Kantor Kecamatan Ciawi. Jika KTP hilang, wajib membawa Surat Kehilangan Polsek.',
                'keywords'    => 'ktp, e-ktp, ktp-el, kk, kartu keluarga, 17 tahun, hilang, rusak, rekam',
                'token_count' => 70,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'guide_id'    => null,
                'faq_id'      => 4,
                'title'       => 'Jam Operasional Kantor Desa Sukamaju',
                'chunk_text'  => 'Jam pelayanan kantor Desa Sukamaju adalah Senin sampai Jumat pukul 08:00 hingga 15:00 WIB. Istirahat pukul 12:00 - 13:00 WIB (Jumat 11:30 - 13:00 WIB). Sabtu dan Minggu libur.',
                'keywords'    => 'jam buka, jam kerja, operasional, kantor desa, jadwal, hari buka',
                'token_count' => 45,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('guide_chunks')->ignore(true)->insertBatch($chunks);

        // 8. VILLAGE INFOS
        $villageInfos = [
            [
                'slug'         => 'jadwal-posyandu-melati-rw03',
                'title'        => 'Jadwal Pelayanan Posyandu Melati RW 03 Bulan Oktober',
                'category'     => 'schedule',
                'content'      => 'Diberitahukan kepada seluruh ibu hamil dan warga yang memiliki balita di lingkungan RW 03 Desa Sukamaju bahwa penimbangan balita, imunisasi dasar, dan pemberian vitamin A akan dilaksanakan pada hari Rabu, 15 Oktober 2026 pukul 08:30 WIB bertempat di Balai RW 03.',
                'banner_image' => 'img/poster-posyandu.png',
                'is_priority'  => 1,
                'valid_until'  => date('Y-m-d', strtotime('+20 days')),
                'status'       => 'published',
                'created_by'   => 2,
                'verified_by'  => 3,
                'published_at' => date('Y-m-d H:i:s', strtotime('-1 days')),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'slug'         => 'musrenbangdes-sukamaju-2026',
                'title'        => 'Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes)',
                'category'     => 'agenda',
                'content'      => 'Pemerintah Desa Sukamaju mengundang seluruh perwakilan RT, RW, tokoh masyarakat, dan kelompok pemuda untuk menghadiri Musrenbangdes Penyusunan RKPDes Tahun Anggaran Mendatang pada Sabtu, 24 Oktober 2026 di Aula Utama Kantor Desa Sukamaju.',
                'banner_image' => 'img/poster-musrenbangdes.png',
                'is_priority'  => 0,
                'valid_until'  => date('Y-m-d', strtotime('+30 days')),
                'status'       => 'published',
                'created_by'   => 2,
                'verified_by'  => 3,
                'published_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'slug'         => 'jam-pelayanan-terbaru-kantor-desa',
                'title'        => 'Informasi Jam Pelayanan Terpadu Satu Pintu Kantor Desa',
                'category'     => 'announcement',
                'content'      => 'Mulai 1 Oktober 2026, Kantor Desa Sukamaju memberlakukan percepatan Pelayanan Terpadu Satu Pintu (PTSP). Pengurusan administrasi surat pengantar dapat diselesaikan dalam 15-30 menit jika berkas telah lengkap sesuai panduan Desentra.',
                'banner_image' => 'img/poster-kantor-desa.png',
                'is_priority'  => 1,
                'valid_until'  => date('Y-m-d', strtotime('+60 days')),
                'status'       => 'published',
                'created_by'   => 2,
                'verified_by'  => 3,
                'published_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('village_infos')->ignore(true)->insertBatch($villageInfos);

        // 9. SAMPLE COMPLAINTS (Pengaduan & Tiket)
        $complaint = [
            'ticket_code'   => 'DSN-20261010-001',
            'title'         => 'Lampu Penerangan Jalan Umum Mati di RT 02 / RW 01',
            'category'      => 'infrastruktur',
            'description'   => 'Lampu jalan tiang nomor 4 di pertigaan gang mesjid mati sejak 3 hari lalu, jalanan menjadi sangat gelap saat malam hari dan rawan kecelakaan.',
            'contact_reply' => '081298765432',
            'status'        => 'in_progress',
            'created_at'    => date('Y-m-d H:i:s', strtotime('-1 days')),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        $db->table('complaints')->ignore(true)->insert($complaint);

        $complaintId = $db->insertID();
        if ($complaintId) {
            $history = [
                [
                    'complaint_id'        => $complaintId,
                    'status'              => 'received',
                    'public_note'         => 'Laporan telah diterima oleh sistem Desentra.',
                    'internal_note'       => 'Tiket otomatis dibuat dari portal pengaduan warga.',
                    'updated_by_admin_id' => null,
                    'created_at'          => date('Y-m-d H:i:s', strtotime('-1 days')),
                ],
                [
                    'complaint_id'        => $complaintId,
                    'status'              => 'in_progress',
                    'public_note'         => 'Petugas seksi sarana dan prasarana desa sedang berkoordinasi dengan PLN untuk penggantian lampu jalan.',
                    'internal_note'       => 'Petugas Pak Junaedi sudah ditugaskan ke lokasi hari ini.',
                    'updated_by_admin_id' => 1,
                    'created_at'          => date('Y-m-d H:i:s'),
                ],
            ];
            $db->table('complaint_status_history')->insertBatch($history);
        }
    }
}
