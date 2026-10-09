<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceGuideModel extends Model
{
    protected $table            = 'service_guides';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'slug', 'title', 'category', 'summary', 'description', 
        'steps_json', 'estimated_duration', 'fee_description', 'icon', 
        'status', 'created_by', 'verified_by', 'checked_at', 'published_at'
    ];
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getPublishedGuides($limit = null, $category = null, $search = null)
    {
        $builder = $this->where('status', 'published');

        if ($category && $category !== 'all') {
            $builder->where('category', $category);
        }

        if ($search) {
            $builder->groupStart()
                    ->like('title', $search)
                    ->orLike('summary', $search)
                    ->orLike('category', $search)
                    ->groupEnd();
        }

        $builder->orderBy('title', 'ASC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    public function getGuideWithDetails($slug)
    {
        $guide = $this->where('slug', $slug)
                      ->where('status', 'published')
                      ->first();

        if (!$guide) {
            return null;
        }

        $db = \Config\Database::connect();

        // Ambil requirements
        $guide['requirements'] = $db->table('guide_requirements')
                                    ->where('guide_id', $guide['id'])
                                    ->orderBy('order_position', 'ASC')
                                    ->get()
                                    ->getResultArray();

        // Ambil sumber resmi
        $guide['sources'] = $db->table('guide_sources')
                               ->select('content_sources.*, guide_sources.citation_note')
                               ->join('content_sources', 'content_sources.id = guide_sources.source_id')
                               ->where('guide_sources.guide_id', $guide['id'])
                               ->get()
                               ->getResultArray();

        // Ambil FAQs terkait
        $guide['faqs'] = $db->table('faqs')
                            ->where('service_guide_id', $guide['id'])
                            ->where('status', 'published')
                            ->get()
                            ->getResultArray();

        return $guide;
    }
}
