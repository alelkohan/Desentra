<?php

namespace App\Models;

use CodeIgniter\Model;

class GuideChunkModel extends Model
{
    protected $table            = 'guide_chunks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'guide_id', 'faq_id', 'title', 'chunk_text', 'keywords', 'token_count', 'created_at'
    ];

    /**
     * Search published verified chunks by query keywords / semantic matching
     */
    public function searchChunks($query, $limit = 3)
    {
        $db = \Config\Database::connect();
        
        // Bersihkan query dan singkirkan stopwords umum (jangan buang kata fungsional seperti jam, buka, biaya)
        $cleanQuery = trim($query);
        $rawWords = preg_split('/\s+/', strtolower($cleanQuery));
        
        $stopwords = [
            'bagaimana', 'gimana', 'cara', 'membuat', 'bikin', 'mengurus', 'urus', 
            'apa', 'apakah', 'berapa', 'kapan', 'dimana', 'kemana', 'siapa', 'mengapa', 'kenapa',
            'saja', 'dan', 'yang', 'untuk', 'dari', 'adalah', 
            'di', 'ke', 'ini', 'itu', 'saya', 'mau', 'dong', 'kah', 
            'pada', 'dengan', 'atau', 'ingin', 'tolong'
        ];

        $words = array_filter($rawWords, function($w) use ($stopwords) {
            return strlen($w) >= 3 && !in_array($w, $stopwords);
        });

        if (empty($words)) {
            return [];
        }

        // Ambil semua chunk dari panduan/FAQ yang berstatus published
        $candidates = $db->table('guide_chunks')
                         ->select('guide_chunks.*, service_guides.title as guide_title, service_guides.slug as guide_slug, service_guides.checked_at, service_guides.status as guide_status, faqs.question as faq_question')
                         ->join('service_guides', 'service_guides.id = guide_chunks.guide_id', 'left')
                         ->join('faqs', 'faqs.id = guide_chunks.faq_id', 'left')
                         ->groupStart()
                            ->where('service_guides.status', 'published')
                            ->orWhere('faqs.status', 'published')
                         ->groupEnd()
                         ->get()
                         ->getResultArray();

        $scored = [];
        $seenEntities = []; // Hindari duplikasi panduan / FAQ yang sama

        foreach ($candidates as $cand) {
            $entityKey = !empty($cand['guide_id']) ? 'guide_' . $cand['guide_id'] : 'faq_' . $cand['faq_id'];
            if (isset($seenEntities[$entityKey])) {
                continue;
            }

            $score = 0;
            // Ambil token dari keywords, title, dan chunk text
            $keywordsTitle = strtolower(($cand['keywords'] ?? '') . ' ' . ($cand['title'] ?? '') . ' ' . ($cand['guide_title'] ?? '') . ' ' . ($cand['faq_question'] ?? ''));
            $corpusWords = preg_split('/[\s,\.\-\(\)\/]+/', $keywordsTitle);
            $corpusWords = array_filter($corpusWords);

            $chunkTextLower = strtolower($cand['chunk_text'] ?? '');

            foreach ($words as $queryWord) {
                // Kecocokan kata eksak di judul / keywords (bobot tinggi)
                if (in_array($queryWord, $corpusWords)) {
                    $score += 4;
                } else {
                    // Cek kemiripan awalan minimal 4 huruf (contoh: 'kelahiran' vs 'lahir')
                    foreach ($corpusWords as $cw) {
                        if (strlen($queryWord) >= 4 && strlen($cw) >= 4) {
                            if (str_starts_with($cw, $queryWord) || str_starts_with($queryWord, $cw)) {
                                $score += 2;
                                break;
                            }
                        }
                    }
                }

                // Kecocokan di isi chunk teks
                if (str_contains($chunkTextLower, $queryWord)) {
                    $score += 1;
                }
            }

            if ($score > 0) {
                $cand['relevance_score'] = $score;
                $scored[] = $cand;
                $seenEntities[$entityKey] = true;
            }
        }

        // Urutkan berdasarkan skor relevansi tertinggi
        usort($scored, function($a, $b) {
            return $b['relevance_score'] <=> $a['relevance_score'];
        });

        if (empty($scored)) {
            return [];
        }

        // Filter: hanya sertakan yang skornya signifikan (>= 2 dan minimal 40% dari skor teratas)
        $topScore = $scored[0]['relevance_score'];
        $filtered = array_filter($scored, function($cand) use ($topScore) {
            return $cand['relevance_score'] >= max(2, (int) ceil($topScore * 0.4));
        });

        return array_slice(array_values($filtered), 0, $limit);
    }

    /**
     * Synchronize / Rebuild RAG chunk for a service guide
     */
    public function syncGuideChunk($guideId)
    {
        $db = \Config\Database::connect();
        $guide = $db->table('service_guides')->where('id', $guideId)->get()->getRowArray();
        if (!$guide) {
            $this->where('guide_id', $guideId)->delete();
            return;
        }

        // Ambil syarat
        $reqs = $db->table('guide_requirements')->where('guide_id', $guideId)->get()->getResultArray();
        $reqTitles = array_map(fn($r) => $r['title'], $reqs);

        // Parse langkah
        $stepsList = [];
        if (!empty($guide['steps_json'])) {
            $decoded = json_decode($guide['steps_json'], true);
            if (is_array($decoded)) {
                foreach ($decoded as $st) {
                    if (is_array($st)) {
                        $stepsList[] = ($st['title'] ?? '') . ': ' . ($st['description'] ?? '');
                    } else {
                        $stepsList[] = (string)$st;
                    }
                }
            }
        }

        $chunkText = "PANDUAN LAYANAN DESA: " . $guide['title'] . "\n";
        $chunkText .= "Kategori: " . $guide['category'] . "\n";
        $chunkText .= "Ringkasan: " . $guide['summary'] . "\n";
        if (!empty($guide['description'])) {
            $chunkText .= "Keterangan: " . $guide['description'] . "\n";
        }
        if (!empty($reqTitles)) {
            $chunkText .= "Persyaratan Dokumen: " . implode(', ', $reqTitles) . ".\n";
        }
        if (!empty($stepsList)) {
            $chunkText .= "Prosedur / Langkah: " . implode(' -> ', $stepsList) . ".\n";
        }
        $chunkText .= "Biaya: " . ($guide['fee_description'] ?? 'Gratis') . ".\n";
        $chunkText .= "Estimasi Waktu: " . ($guide['estimated_duration'] ?? '15 Menit') . ".\n";

        // Generate keywords
        $keywords = strtolower($guide['title'] . ' ' . $guide['category'] . ' ' . $guide['slug'] . ' ' . implode(' ', $reqTitles) . ' syarat biaya prosedur langkah');
        $tokenCount = (int) ceil(strlen($chunkText) / 4);

        // Cek existing chunk
        $existing = $this->where('guide_id', $guideId)->first();
        if ($existing) {
            $this->update($existing['id'], [
                'title'       => $guide['title'],
                'chunk_text'  => $chunkText,
                'keywords'    => $keywords,
                'token_count' => $tokenCount,
            ]);
        } else {
            $this->insert([
                'guide_id'    => $guideId,
                'title'       => $guide['title'],
                'chunk_text'  => $chunkText,
                'keywords'    => $keywords,
                'token_count' => $tokenCount,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Synchronize / Rebuild RAG chunk for a FAQ
     */
    public function syncFaqChunk($faqId)
    {
        $db = \Config\Database::connect();
        $faq = $db->table('faqs')->where('id', $faqId)->get()->getRowArray();
        if (!$faq) {
            $this->where('faq_id', $faqId)->delete();
            return;
        }

        $chunkText = "FAQ DESA: " . $faq['question'] . "\nJawaban: " . $faq['answer'];
        $keywords = strtolower($faq['question'] . ' ' . ($faq['category'] ?? '') . ' faq tanya jawab');
        $tokenCount = (int) ceil(strlen($chunkText) / 4);

        $existing = $this->where('faq_id', $faqId)->first();
        if ($existing) {
            $this->update($existing['id'], [
                'title'       => $faq['question'],
                'chunk_text'  => $chunkText,
                'keywords'    => $keywords,
                'token_count' => $tokenCount,
            ]);
        } else {
            $this->insert([
                'faq_id'      => $faqId,
                'title'       => $faq['question'],
                'chunk_text'  => $chunkText,
                'keywords'    => $keywords,
                'token_count' => $tokenCount,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * Synchronize all published guides and FAQs into RAG chunks
     */
    public function syncAllChunks()
    {
        $db = \Config\Database::connect();
        $guides = $db->table('service_guides')->where('status', 'published')->get()->getResultArray();
        foreach ($guides as $g) {
            $this->syncGuideChunk($g['id']);
        }

        $faqs = $db->table('faqs')->where('status', 'published')->get()->getResultArray();
        foreach ($faqs as $f) {
            $this->syncFaqChunk($f['id']);
        }
    }
}
