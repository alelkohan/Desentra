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

    public function __construct()
    {
        $this->chunkModel = new GuideChunkModel();
        $this->questionModel = new ResidentQuestionModel();
        $this->apiKey = env('GEMINI_API_KEY', '');
        $this->model = env('GEMINI_MODEL', 'gemini-1.5-flash');
    }

    /**
     * Menjawab pertanyaan warga dengan metode Retrieval-Augmented Generation (RAG)
     */
    public function ask($question, $sessionId = null, $userId = null)
    {
        $question = trim($question);

        // 1. Validasi input: cek batasan panjang & deteksi potensi NIK (16 digit angka berurutan)
        if (mb_strlen($question) < 3) {
            return [
                'success' => false,
                'message' => 'Pertanyaan terlalu pendek. Silakan ketik pertanyaan Anda dengan lebih jelas.'
            ];
        }

        if (preg_match('/\b\d{16}\b/', $question)) {
            return [
                'success' => true,
                'is_fallback' => true,
                'answer' => 'Demi keamanan dan privasi data kependudukan Anda, sistem Desentra **tidak memerlukan NIK atau data pribadi sensitif**. Silakan ajukan pertanyaan tanpa menyertakan nomor identitas.',
                'sources' => [],
                'official_contact' => env('DESENTRA_OFFICIAL_CONTACT', '+62 812-3456-7890'),
            ];
        }

        // 2. Retrieval: Cari potongan sumber panduan yang terbit & terverifikasi
        $chunks = $this->chunkModel->searchChunks($question, 3);

        // Jika tidak ada sumber yang cocok sama sekali -> Fallback
        if (empty($chunks)) {
            $fallbackAnswer = "Mohon maaf, informasi mengenai pertanyaan tersebut belum tercantum dalam panduan resmi desa yang terverifikasi saat ini. Pertanyaan Anda telah kami teruskan ke antrean admin desa untuk peninjauan panduan lebih lanjut. Untuk bantuan langsung, Anda dapat menghubungi kantor desa atau membuat laporan di menu Pengaduan.";

            $questionId = $this->logQuestion($userId, $sessionId, $question, $fallbackAnswer, true, 'needs_review');

            return [
                'success' => true,
                'is_fallback' => true,
                'answer' => $fallbackAnswer,
                'sources' => [],
                'question_id' => $questionId,
                'official_contact' => env('DESENTRA_OFFICIAL_CONTACT', '+62 812-3456-7890'),
            ];
        }

        // 3. Menyiapkan konteks sumber untuk AI
        $contextText = "";
        $sourcesMeta = [];

        foreach ($chunks as $index => $c) {
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

        // 4. Generation: Panggil Gemini API jika API key tersedia, atau gunakan Local Grounded Synthesizer
        $aiAnswer = null;
        if (!empty($this->apiKey)) {
            $aiAnswer = $this->callGeminiApi($question, $contextText);
        }

        // Fallback jika API key belum diset atau ada kendala koneksi ke Gemini
        if (empty($aiAnswer)) {
            $aiAnswer = $this->synthesizeLocalResponse($question, $chunks);
        }

        // 5. Simpan riwayat pertanyaan & sumber yang digunakan
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
            'official_contact' => env('DESENTRA_OFFICIAL_CONTACT', '+62 812-3456-7890'),
        ];
    }

    /**
     * Memanggil Gemini API dengan Grounding System Prompt
     */
    protected function callGeminiApi($question, $contextText)
    {
        $systemPrompt = "Anda adalah Asisten Virtual Resmi Desentra (Desa Sukamaju). Tugas Anda adalah menjawab pertanyaan warga mengenai panduan administrasi dan informasi desa secara ramah, ringkas, jelas, dan akurat.\n\n"
            . "ATURAN KETAT:\n"
            . "1. Jawab HANYA berdasarkan konteks sumber terbit yang diberikan di bawah ini.\n"
            . "2. JANGAN mengarang syarat, biaya, atau prosedur yang tidak ada dalam konteks.\n"
            . "3. Gunakan bahasa Indonesia yang santun dan mudah dipahami orang awam.\n"
            . "4. Jika informasi pada sumber tidak cukup lengkap, beri tahu warga dengan sopan dan sarankan menghubungi kantor desa.\n"
            . "5. Jangan pernah meminta NIK warga.\n\n"
            . "KONTEKS SUMBER TERVERIFIKASI:\n" . $contextText;

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
                'temperature'     => 0.2,
                'maxOutputTokens' => 600,
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
     * Generator jawaban lokal yang merangkum langsung dari chunk terverifikasi
     */
    protected function synthesizeLocalResponse($question, $chunks)
    {
        $first = $chunks[0];
        $title = $first['guide_title'] ?? $first['title'];

        $text = "Berdasarkan panduan resmi terverifikasi mengenai **{$title}**:\n\n";
        $text .= $first['chunk_text'] . "\n\n";

        if (count($chunks) > 1) {
            $text .= "Informasi terkait lainnya:\n";
            for ($i = 1; $i < count($chunks); $i++) {
                $t = $chunks[$i]['guide_title'] ?? $chunks[$i]['title'];
                $text .= "• **{$t}**: " . $chunks[$i]['chunk_text'] . "\n";
            }
        }

        $text .= "\n*Catatan: Informasi di atas bersumber dari data resmi Pemerintah Desa Sukamaju.*";
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
