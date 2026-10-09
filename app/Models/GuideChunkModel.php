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
        
        // Bersihkan query dan singkirkan stopwords umum
        $cleanQuery = trim($query);
        $rawWords = preg_split('/\s+/', strtolower($cleanQuery));
        
        $stopwords = [
            'bagaimana', 'gimana', 'cara', 'membuat', 'bikin', 'mengurus', 'urus', 
            'apa', 'apakah', 'saja', 'dan', 'yang', 'untuk', 'dari', 'bisa', 'adalah', 
            'di', 'ke', 'ini', 'itu', 'desa', 'surat', 'saya', 'mau', 'dong', 'kah', 
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

        foreach ($candidates as $cand) {
            $score = 0;
            // Ambil token dari keywords dan title
            $corpus = strtolower(($cand['keywords'] ?? '') . ' ' . ($cand['title'] ?? '') . ' ' . ($cand['guide_title'] ?? ''));
            // Pisahkan menjadi kata-kata mandiri
            $corpusWords = preg_split('/[\s,\.\-\(\)\/]+/', $corpus);
            $corpusWords = array_filter($corpusWords);

            foreach ($words as $queryWord) {
                // Kecocokan kata eksak (bobot tinggi)
                if (in_array($queryWord, $corpusWords)) {
                    $score += 3;
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
            }

            if ($score > 0) {
                $cand['relevance_score'] = $score;
                $scored[] = $cand;
            }
        }

        // Urutkan berdasarkan skor relevansi tertinggi
        usort($scored, function($a, $b) {
            return $b['relevance_score'] <=> $a['relevance_score'];
        });

        return array_slice($scored, 0, $limit);
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
                    $stepsList[] = ($st['title'] ?? '') . ': ' . ($st['description'] ?? '');
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
        $chunkText .= "Estimasi Waktu: " . ($guide['estimated_duration'] ?? '1 hari kerja') . ".\n";

        // Generate keywords
        $keywords = strtolower($guide['title'] . ' ' . $guide['category'] . ' ' . implode(' ', $reqTitles));
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
}
