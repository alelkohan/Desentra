<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 'faqs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'service_guide_id', 'question', 'answer', 'category', 'status', 
        'created_by', 'verified_by'
    ];
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getPublishedFaqs($category = null)
    {
        $builder = $this->where('status', 'published');
        if ($category && $category !== 'all') {
            $builder->where('category', $category);
        }
        return $builder->findAll();
    }
}
