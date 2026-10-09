<?php

namespace App\Models;

use CodeIgniter\Model;

class GuideRequirementModel extends Model
{
    protected $table            = 'guide_requirements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'guide_id', 'title', 'description', 'is_mandatory', 'order_position', 'created_at'
    ];
    protected $useTimestamps    = false;
}
