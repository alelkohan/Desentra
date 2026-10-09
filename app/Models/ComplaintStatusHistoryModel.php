<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplaintStatusHistoryModel extends Model
{
    protected $table            = 'complaint_status_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'complaint_id', 'status', 'public_note', 'internal_note', 
        'updated_by_admin_id', 'created_at'
    ];
}
