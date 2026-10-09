<?php

namespace App\Models;

use CodeIgniter\Model;

class VillageInfoModel extends Model
{
    protected $table            = 'village_infos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'slug', 'title', 'category', 'content', 'banner_image', 
        'is_priority', 'valid_until', 'status', 'created_by', 
        'verified_by', 'published_at'
    ];
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function getActiveInfos($category = null, $limit = null)
    {
        $today = date('Y-m-d');
        $builder = $this->where('status', 'published')
                        ->groupStart()
                            ->where('valid_until IS NULL')
                            ->orWhere('valid_until >=', $today)
                        ->groupEnd();

        if ($category && $category !== 'all') {
            $builder->where('category', $category);
        }

        $builder->orderBy('published_at', 'DESC')
                ->orderBy('id', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }
}
