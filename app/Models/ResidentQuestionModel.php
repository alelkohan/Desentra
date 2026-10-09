<?php

namespace App\Models;

use CodeIgniter\Model;

class ResidentQuestionModel extends Model
{
    protected $table            = 'resident_questions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'resident_user_id', 'session_uuid', 'question_text', 'answer_text', 
        'is_fallback', 'confidence_score', 'status', 'created_at'
    ];
    protected $useTimestamps    = false;
}
