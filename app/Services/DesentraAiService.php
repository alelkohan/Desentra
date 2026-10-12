<?php

namespace App\Services;

use App\Models\GuideChunkModel;
use App\Models\ResidentQuestionModel;

class DesentraAiService
{
    protected $chunkModel;
    protected $questionModel;
    protected $apiKey;
    protected $model;
    protected $villageName;
    protected $officialContact;

    public function __construct()
    {
        $this->chunkModel      = new GuideChunkModel();
        $this->questionModel   = new ResidentQuestionModel();
        $this->apiKey          = env('GEMINI_API_KEY', '');
        $this->model           = env('GEMINI_MODEL', 'gemini-1.5-flash');
        $this->villageName     = env('DESENTRA_VILLAGE_NAME', 'Desa Sukamaju');
        $this->officialContact = env('DESENTRA_OFFICIAL_CONTACT', '+62 812-3456-7890');
    }

    /**
     * Menjawab pertanyaan warga dengan metode Retrieval-Augmented Generation (RAG)
     * yang dilengkapi conversational intent detection agar respon ramah & manusiawi.
     */
    public function ask($question, $sessionId = null, $userId = null)
    {
        $question = trim($question);

        // 1. Validasi input: cek batasan panjang
        if (mb_strlen($question) < 2) {
            return [
                'success' => false,
                'message' => 'Pertanyaan terlalu pendek. Silakan ketik pertanyaan Anda dengan lebih jelas.'
            ];
        }

        // 2. Proteksi Privasi: deteksi NIK (16 digit angka berurutan)
        if (preg_match('/\b\d{16}\b/', $question)) {
            return [
                'success'          => true,
                'is_fallback'      => true,
                'answer'           => "Halo! Demi menjaga keamanan dan privasi data kependudukan Anda, sistem Desentra **tidak memerlukan NIK atau nomor identitas pribadi sensitif** untuk mengecek syarat surat dan informasi layanan desa.\n\nSilakan ajukan pertanyaan Anda kembali secara umum (contoh: *\"Apa saja syarat membuat SKTM?\"* atau *\"Bagaimana alur pembuatan akta kelahiran?\"*). Kami siap membantu!",
                'sources'          => [],
                'official_contact' => $this->officialContact,
            ];
        }

        // 3. Deteksi Conversational Intent (Sapaan, Terima Kasih, Persona, Jam Kerja, Biaya Umum)
        $conversationalResponse = $this->handleConversationalIntent($question, $sessionId, $userId);
        if ($conversationalResponse !== null) {
            return $conversationalResponse;
        }

        // 4. Retrieval: Cari potongan sumber panduan yang terbit & terverifikasi
        $chunks = $this->chunkModel->searchChunks($question, 3);

        // Jika tidak ada sumber yang cocok sama sekali -> Humanized Fallback
        if (empty($chunks)) {
            $fallbackAnswer = "Halo! Mohon maaf, saat ini rincian mengenai pertanyaan Anda belum tercantum di dalam panduan resmi desa yang telah terverifikasi di sistem kami.\n\n"
                . "Pertanyaan Anda telah kami catat ke dalam antrean peninjauan admin desa agar materi panduan layanan kami dapat segera dilengkapi.\n\n"
                . "📞 **Bantuan Langsung:**\n"
                . "Untuk informasi mendesak, Anda dapat:\n"
                . "• Menghubungi kontak resmi desa di **{$this->officialContact}**\n"
                . "• Datang langsung ke loket pelayanan kantor desa pada jam kerja (Senin–Jumat, 08.00–15.00 WIB)\n"
                . "• Atau mengirim pesan/laporan melalui menu **Pengaduan Warga** di Desentra.\n\n"
                . "Apakah ada informasi persyaratan surat desa lainnya yang bisa kami bantu jelaskan?";

            $questionId = $this->logQuestion($userId, $sessionId, $question, $fallbackAnswer, true, 'needs_review');

            return [
                'success'          => true,
                'is_fallback'      => true,
                'answer'           => $fallbackAnswer,
                'sources'          => [],
                'question_id'      => $questionId,
                'official_contact' => $this->officialContact,
            ];
        }

        // 5. Menyiapkan konteks sumber untuk AI
        $contextText = "";
        $sourcesMeta = [];

        // Filter: Jika chunk teratas adalah panduan layanan spesifik, jangan sertakan panduan layanan lain yang tidak relevan
        $topGuideId = $chunks[0]['guide_id'] ?? null;
        $topFaqId   = $chunks[0]['faq_id'] ?? null;
        $usedChunks = [];

        foreach ($chunks as $c) {
            if ($topGuideId !== null) {
                // Sertakan panduan yang sama, atau FAQ yang relevan
                if (!empty($c['guide_id']) && $c['guide_id'] == $topGuideId) {
                    $usedChunks[] = $c;
                } elseif (!empty($c['faq_id'])) {
                    $usedChunks[] = $c;
                }
            } elseif ($topFaqId !== null) {
                if (!empty($c['faq_id']) && $c['faq_id'] == $topFaqId) {
                    $usedChunks[] = $c;
                }
            } else {
                $usedChunks[] = $c;
            }
        }

        if (empty($usedChunks)) {
            $usedChunks = [$chunks[0]];
        }

        foreach ($usedChunks as $index => $c) {
            $sourceNum = $index + 1;
            $title = $c['guide_title'] ?? $c['title'];
            $contextText .= "[Sumber {$sourceNum}: {$title}]\n{$c['chunk_text']}\n\n";

            $sourcesMeta[] = [
                'chunk_id'   => $c['id'],
                'title'      => $title,
                'slug'       => $c['guide_slug'] ?? null,
                'checked_at' => $c['checked_at'] ? date('d M Y', strtotime($c['checked_at'])) : date('d M Y'),
                'snippet'    => mb_substr($c['chunk_text'], 0, 120) . '...',
            ];
        }

        // 6. Generation: Panggil Gemini API jika API key tersedia, atau gunakan Local Grounded Synthesizer
        $aiAnswer = null;
        if (!empty($this->apiKey)) {
            $aiAnswer = $this->callGeminiApi($question, $contextText);
        }

        // Fallback jika API key belum diset atau ada kendala koneksi ke Gemini
        if (empty($aiAnswer)) {
            $aiAnswer = $this->synthesizeLocalResponse($question, $chunks);
        }

        // 7. Simpan riwayat pertanyaan & sumber yang digunakan
        $questionId = $this->logQuestion($userId, $sessionId, $question, $aiAnswer, false, 'answered');

        if ($questionId && !empty($sourcesMeta)) {
            $db = \Config\Database::connect();
            foreach ($sourcesMeta as $sm) {
                $db->table('question_sources')->insert([
                    'question_id'   => $questionId,
                    'chunk_id'      => $sm['chunk_id'],
                    'citation_text' => $sm['title'],
                ]);
            }
        }

        return [
            'success'          => true,
            'is_fallback'      => false,
            'answer'           => $aiAnswer,
            'sources'          => $sourcesMeta,
            'question_id'      => $questionId,
            'official_contact' => $this->officialContact,
        ];
    }

    /**
     * Menangani interaksi percakapan natural (salam, terima kasih, perkenalan, jam buka, biaya umum)
     * agar asisten terasa manusiawi, ramah, dan solutif.
     */
    protected function handleConversationalIntent($question, $sessionId, $userId)
    {
        $q = strtolower($question);

        // A. Sapaan / Salam
        if (preg_match('/\b(halo|hai|hey|hei|assalamu[\'\s]?alaikum|samlikum|selamat\s+(pagi|siang|sore|malam)|pagi|siang|sore|malam|permisi|kulonuwun|sampurasun|punten|tes|test|testing)\b/i', $q) &&
            !preg_match('/\b(syarat|cara|buat|bikin|urus|sktm|ktp|kk|akta|usaha|skdu|kelahiran|surat|nik|lapor|aduan|jadwal|jam|biaya)\b/i', $q)) {
            $answer = "Halo! Selamat datang di layanan asisten virtual **Desentra** ({$this->villageName}). 👋\n\n"
                . "Saya siap membantu Anda dengan informasi panduan administrasi desa secara mudah dan cepat, antara lain:\n"
                . "• **Syarat & Alur Surat Desa:** SKTM, KTP-el, Kartu Keluarga, Akta Kelahiran, dan Surat Usaha (SKDU)\n"
                . "• **Jam Operasional:** Jadwal pelayanan loket kantor desa\n"
                . "• **Biaya Layanan:** Informasi biaya (semua surat resmi desa gratis / Rp 0)\n\n"
                . "Ada yang bisa kami bantu untuk keperluan surat atau berkas Anda hari ini?";

            $questionId = $this->logQuestion($userId, $sessionId, $question, $answer, false, 'answered');

            return [
                'success'          => true,
                'is_fallback'      => false,
                'answer'           => $answer,
                'sources'          => [],
                'question_id'      => $questionId,
                'official_contact' => $this->officialContact,
            ];
        }

        // B. Ucapan Terima Kasih
        if (preg_match('/\b(terima\s*kasih|makasih|matur\s*nuwun|nuhun|thanks|thank\s*you|syukron|tengkyu|ok\s*makasih|oke\s*makasih|makasi|mksh|tks)\b/i', $q)) {
            $answer = "Sama-sama! Senang sekali bisa membantu Anda. 😊\n\n"
                . "Pastikan seluruh dokumen persyaratan sudah Anda cek dan siapkan sebelum datang ke kantor desa ya. Jika nanti ada hal lain yang perlu ditanyakan, silakan hubungi kami kembali kapan saja.\n\n"
                . "Semoga urusan administrasi Anda berjalan lancar dan sukses!";

            $questionId = $this->logQuestion($userId, $sessionId, $question, $answer, false, 'answered');

            return [
                'success'          => true,
                'is_fallback'      => false,
                'answer'           => $answer,
                'sources'          => [],
                'question_id'      => $questionId,
                'official_contact' => $this->officialContact,
            ];
        }

        // C. Siapa Kamu / Persona
        if (preg_match('/\b(kamu\s*siapa|siapa\s*kamu|siapa\s*anda|anda\s*siapa|kamu\s*ini\s*apa|ini\s*bot\s*apa|kamu\s*bisa\s*apa|bisa\s*bantu\s*apa|apa\s*saja\s*fitur|apa\s*itu\s*desentra)\b/i', $q)) {
            $answer = "Saya adalah **Asisten Virtual Resmi Desentra**, platform pusat pelayanan dan informasi digital masyarakat **{$this->villageName}**. 🏛️\n\n"
                . "Peran saya adalah membantu warga desa agar:\n"
                . "1. **Tahu Syarat Sebelum Berangkat:** Mengetahui dokumen apa saja yang wajib dibawa dari rumah agar tidak perlu bolak-balik.\n"
                . "2. **Paham Alur Pengurusan:** Mengetahui tahapan birokrasi dari pengantar RT/RW hingga tanda tangan Kepala Desa.\n"
                . "3. **Bebas Biaya & Transparan:** Memastikan warga mengetahui bahwa seluruh pelayanan loket desa adalah **Gratis (Rp 0)** bebas pungli.\n\n"
                . "Silakan tanyakan nama surat yang ingin Anda buat, misalnya: *\"Apa syarat membuat SKTM?\"* atau *\"Bagaimana cara membuat akta kelahiran?\"*";

            $questionId = $this->logQuestion($userId, $sessionId, $question, $answer, false, 'answered');

            return [
                'success'          => true,
                'is_fallback'      => false,
                'answer'           => $answer,
                'sources'          => [],
                'question_id'      => $questionId,
                'official_contact' => $this->officialContact,
            ];
        }

        // D. Pujian & Apresiasi
        if (preg_match('/^(mantap|bagus|keren|hebat|pintar|cerdas|jos|mantap\s*jiwa|top|oke\s*banget|sangat\s*membantu|terbantu)[\!\?\.\s]*$/i', $q)) {
            $answer = "Terima kasih banyak atas apresiasi positifnya! 🙏\n\n"
                . "Kami terus berusaha menghadirkan layanan informasi desa yang cepat, ramah, dan mudah dipahami oleh seluruh warga. Jangan ragu untuk bertanya lagi jika Anda membutuhkan panduan layanan lainnya ya!";

            $questionId = $this->logQuestion($userId, $sessionId, $question, $answer, false, 'answered');

            return [
                'success'          => true,
                'is_fallback'      => false,
                'answer'           => $answer,
                'sources'          => [],
                'question_id'      => $questionId,
                'official_contact' => $this->officialContact,
            ];
        }

        // E. Pertanyaan Jam Buka / Operasional Kantor Desa
        if (preg_match('/\b(jam\s*(kerja|buka|operasional|pelayanan|layanan)|buka\s*jam\s*berapa|tutup\s*jam\s*berapa|hari\s*apa\s*(saja\s*)?buka|sabtu\s*buka|minggu\s*buka|jadwal\s*kantor)\b/i', $q)) {
            $answer = "Halo! Berikut jadwal resmi operasional pelayanan loket di **Kantor {$this->villageName}**:\n\n"
                . "🏛️ **Jadwal Pelayanan Kantor Desa:**\n"
                . "• **Senin – Kamis:** Pukul 08.00 – 15.00 WIB\n"
                . "  *(Waktu Istirahat: 12.00 – 13.00 WIB)*\n"
                . "• **Jumat:** Pukul 08.00 – 15.00 WIB\n"
                . "  *(Waktu Istirahat: 11.30 – 13.00 WIB)*\n"
                . "• **Sabtu, Minggu & Hari Libur Nasional:** Tutup (Libur)\n\n"
                . "💡 **Saran Kunjungan:**\n"
                . "Disarankan datang di pagi hari (pukul 08.30 – 11.00 WIB) dengan berkas yang sudah lengkap agar verifikasi dokumen dan pengesahan surat dapat selesai di hari yang sama.\n\n"
                . "Apakah ada syarat surat tertentu yang ingin Anda persiapkan?";

            $sourcesMeta = [
                [
                    'chunk_id'   => null,
                    'title'      => 'SOP Jam Operasional Pelayanan Kantor Desa',
                    'slug'       => null,
                    'checked_at' => date('d M Y'),
                    'snippet'    => 'Pelayanan loket Kantor Desa buka Senin sampai Jumat pukul 08:00 hingga 15:00 WIB...',
                ]
            ];

            $questionId = $this->logQuestion($userId, $sessionId, $question, $answer, false, 'answered');

            return [
                'success'          => true,
                'is_fallback'      => false,
                'answer'           => $answer,
                'sources'          => $sourcesMeta,
                'question_id'      => $questionId,
                'official_contact' => $this->officialContact,
            ];
        }

        // F. Pertanyaan Biaya Pengurusan Surat Desa (Umum)
        if (preg_match('/^(biaya\s*surat|berapa\s*biaya|bayar\s*berapa|apakah\s*gratis|ada\s*pungli|tarif\s*surat|biaya\s*administrasi)[\!\?\.\s]*$/i', $q)) {
            $answer = "Halo! Kami tegaskan bahwa **seluruh pengurusan surat keterangan resmi di loket {$this->villageName} adalah 100% GRATIS (Rp 0)**. 💰❌\n\n"
                . "Pemerintah desa tidak memungut biaya retribusi apapun untuk pembuatan:\n"
                . "• Surat Keterangan Tidak Mampu (SKTM)\n"
                . "• Surat Pengantar Akta Kelahiran\n"
                . "• Pengantar KTP-el dan Kartu Keluarga\n"
                . "• Surat Keterangan Domisili Usaha (SKDU)\n\n"
                . "*(Catatan: Anda hanya perlu menyediakan materai Rp 10.000 sendiri bila jenis surat yang diurus memerlukan surat pernyataan bermaterai).* Apabila Anda menemukan indikasi pungutan liar, Anda dapat segera melaporkannya melalui menu **Pengaduan Warga** di aplikasi Desentra.\n\n"
                . "Ada surat tertentu yang ingin Anda ketahui persyaratannya?";

            $sourcesMeta = [
                [
                    'chunk_id'   => null,
                    'title'      => 'Peraturan Bebas Biaya Layanan Desa (Rp 0)',
                    'slug'       => null,
                    'checked_at' => date('d M Y'),
                    'snippet'    => 'Seluruh penerbitan surat pengantar dan administrasi desa bebas biaya retribusi (gratis)...',
                ]
            ];

            $questionId = $this->logQuestion($userId, $sessionId, $question, $answer, false, 'answered');

            return [
                'success'          => true,
                'is_fallback'      => false,
                'answer'           => $answer,
                'sources'          => $sourcesMeta,
                'question_id'      => $questionId,
                'official_contact' => $this->officialContact,
            ];
        }

        return null;
    }

    /**
     * Memanggil Gemini API dengan Persona Ramah, Santun, dan Berempati
     */
    protected function callGeminiApi($question, $contextText)
    {
        $systemPrompt = "Anda adalah Asisten Virtual Resmi Desentra untuk {$this->villageName}. Tugas Anda adalah melayani dan menjawab pertanyaan warga masyarakat mengenai panduan administrasi desa, persyaratan berkas, dan informasi layanan secara sangat ramah, hangat, empatik, terstruktur, dan akurat.\n\n"
            . "PANDUAN KOMUNIKASI & KARAKTER:\n"
            . "1. Gunakan bahasa Indonesia yang santun, bersahabat, komunikatif, dan mudah dipahami orang awam dari berbagai kalangan usia (layaknya petugas pelayanan desa yang sabar dan profesional).\n"
            . "2. Sapa warga dengan ramah di awal kalimat (misal: 'Halo!', 'Baik, untuk pengurusan...') dan akhiri dengan kalimat penutup yang suportif.\n"
            . "3. Susun jawaban secara terstruktur rapi dengan Markdown: gunakan judul tebal, bullet points/penomoran untuk daftar syarat berkas dan langkah prosedur, serta tekankan biaya 'Gratis (Rp 0)' bila relevan.\n"
            . "4. Jawab HANYA berdasarkan konteks sumber resmi terverifikasi yang diberikan di bawah ini. Jangan mengarang syarat atau regulasi di luar konteks.\n"
            . "5. Jika informasi di sumber kurang lengkap, sampaikan dengan jujur dan santun, lalu arahkan warga untuk berkonsultasi ke loket kantor desa atau nomor kontak resmi {$this->officialContact}.\n"
            . "6. JANGAN PERNAH meminta NIK, nomor rekening, atau dokumen rahasia pribadi warga.\n\n"
            . "KONTEKS SUMBER RESMI DESA TERVERIFIKASI:\n" . $contextText;

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $payload = [
            'contents' => [
                [
                    'role'  => 'user',
                    'parts' => [
                        ['text' => $systemPrompt . "\n\nPertanyaan Warga: " . $question]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature'     => 0.3,
                'maxOutputTokens' => 800,
            ]
        ];

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->post($url, [
                'headers' => ['Content-Type' => 'application/json'],
                'json'    => $payload,
                'timeout' => 8,
            ]);

            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody(), true);
                if (!empty($body['candidates'][0]['content']['parts'][0]['text'])) {
                    return trim($body['candidates'][0]['content']['parts'][0]['text']);
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Gemini API Error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Generator jawaban lokal yang merangkum informasi panduan/FAQ secara kaya,
     * terstruktur, luwes, dan bernada manusiawi layaknya petugas desa.
     */
    protected function synthesizeLocalResponse($question, $chunks)
    {
        $first = $chunks[0];
        $guideId = $first['guide_id'] ?? null;
        $faqId   = $first['faq_id'] ?? null;

        // KASUS A: Sumber adalah PANDUAN LAYANAN LENGKAP (service_guides)
        if (!empty($guideId)) {
            $db = \Config\Database::connect();
            $guide = $db->table('service_guides')->where('id', $guideId)->get()->getRowArray();
            $rawRequirements = $db->table('guide_requirements')
                                  ->where('guide_id', $guideId)
                                  ->orderBy('order_position', 'ASC')
                                  ->get()
                                  ->getResultArray();
            $seenTitles = [];
            $requirements = [];
            foreach ($rawRequirements as $r) {
                $t = trim($r['title']);
                if (!isset($seenTitles[$t])) {
                    $seenTitles[$t] = true;
                    $requirements[] = $r;
                }
            }

            $title = $guide['title'] ?? $first['title'];

            $text = "Halo! Mengenai permohonan **{$title}** di {$this->villageName}, berikut panduan resmi dan kelengkapan berkas yang perlu Anda persiapkan:\n\n";

            // Persyaratan
            if (!empty($requirements)) {
                $text .= "📋 **Dokumen Persyaratan yang Wajib Disiapkan:**\n";
                foreach ($requirements as $idx => $req) {
                    $num = $idx + 1;
                    $mandatoryTag = !empty($req['is_mandatory']) ? '*(Wajib)*' : '*(Bila ada)*';
                    $desc = !empty($req['description']) ? " – " . $req['description'] : "";
                    $text .= "{$num}. **{$req['title']}** {$mandatoryTag}{$desc}\n";
                }
                $text .= "\n";
            }

            // Prosedur / Langkah
            if (!empty($guide['steps_json'])) {
                $steps = json_decode($guide['steps_json'], true);
                if (is_array($steps) && !empty($steps)) {
                    $text .= "🚶‍♂️ **Alur & Tahapan Pengurusan:**\n";
                    foreach ($steps as $idx => $st) {
                        $stepNum = $idx + 1;
                        if (is_array($st)) {
                            $stTitle = $st['title'] ?? '';
                            $stDesc = $st['description'] ?? '';
                            $text .= "{$stepNum}. " . ($stTitle ? "**{$stTitle}**: " : "") . "{$stDesc}\n";
                        } else {
                            $text .= "{$stepNum}. {$st}\n";
                        }
                    }
                    $text .= "\n";
                }
            }

            // Biaya & Waktu
            $fee = $guide['fee_description'] ?? 'Gratis (Rp 0)';
            $duration = $guide['estimated_duration'] ?? '15 – 30 Menit';
            $text .= "💰 **Biaya Layanan:** **{$fee}** (Seluruh pelayanan desa bebas pungutan liar)\n";
            $text .= "⏱️ **Estimasi Waktu:** Sekitar **{$duration}** (apabila berkas lengkap dan pejabat berwenang ada di tempat)\n\n";

            // Keterangan / Deskripsi
            if (!empty($guide['description'])) {
                $text .= "💡 **Keterangan:**\n{$guide['description']}\n\n";
            }

            // Tips ramah
            $text .= "📌 **Tips untuk Pemohon:**\n"
                . "Pastikan membawa dokumen asli (seperti KTP & KK asli) untuk pencocokan data di loket desa. Loket buka hari Senin–Jumat pukul 08.00–15.00 WIB.\n\n"
                . "Semoga proses pengurusan surat Anda berjalan lancar! Jika ada syarat yang belum Anda pahami, silakan tanyakan kembali ya. 😊";

            return $text;
        }

        // KASUS B: Sumber adalah FAQ (Tanya Jawab Desa)
        if (!empty($faqId)) {
            $db = \Config\Database::connect();
            $faq = $db->table('faqs')->where('id', $faqId)->get()->getRowArray();
            $faqQuestion = $faq['question'] ?? $first['title'];
            $faqAnswer   = $faq['answer'] ?? $first['chunk_text'];

            $text = "Halo! Mengenai pertanyaan tersebut, berikut informasi resmi dari Pemerintah {$this->villageName}:\n\n";
            $text .= "📌 **{$faqQuestion}**\n";
            $text .= "{$faqAnswer}\n\n";

            // Tambahkan rujukan jika ada chunk pendukung lainnya
            if (count($chunks) > 1) {
                $text .= "Informasi terkait lainnya:\n";
                for ($i = 1; $i < count($chunks); $i++) {
                    $t = $chunks[$i]['guide_title'] ?? $chunks[$i]['title'];
                    $text .= "• **{$t}**: " . $chunks[$i]['chunk_text'] . "\n";
                }
                $text .= "\n";
            }

            $text .= "Apakah informasi ini sudah cukup jelas, atau ada hal lain seputar layanan desa yang ingin Anda pastikan kembali?";
            return $text;
        }

        // KASUS C: General chunk synthesis
        $title = $first['guide_title'] ?? $first['title'];
        $text = "Halo! Berdasarkan panduan resmi terverifikasi mengenai **{$title}** di {$this->villageName}:\n\n";
        $text .= $first['chunk_text'] . "\n\n";

        if (count($chunks) > 1) {
            $text .= "📌 **Informasi Terkait Lainnya:**\n";
            for ($i = 1; $i < count($chunks); $i++) {
                $t = $chunks[$i]['guide_title'] ?? $chunks[$i]['title'];
                $text .= "• **{$t}**: " . $chunks[$i]['chunk_text'] . "\n";
            }
            $text .= "\n";
        }

        $text .= "Semoga panduan di atas membantu Anda. Silakan tanyakan kembali jika ada poin yang memerlukan penjelasan lebih detail ya!";
        return $text;
    }

    protected function logQuestion($userId, $sessionId, $question, $answer, $isFallback, $status)
    {
        try {
            $data = [
                'resident_user_id' => $userId,
                'session_uuid'     => $sessionId ?: bin2hex(random_bytes(16)),
                'question_text'    => $question,
                'answer_text'      => $answer,
                'is_fallback'      => $isFallback ? 1 : 0,
                'confidence_score' => $isFallback ? 0.2 : 0.95,
                'status'           => $status,
                'created_at'       => date('Y-m-d H:i:s'),
            ];
            $this->questionModel->insert($data);
            return $this->questionModel->getInsertID();
        } catch (\Exception $e) {
            log_message('error', 'Log question error: ' . $e->getMessage());
            return null;
        }
    }
}
