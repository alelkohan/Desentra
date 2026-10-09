<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminAuditLogModel extends Model
{
    protected $table            = 'admin_audit_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'admin_user_id', 'action', 'entity_name', 'entity_id', 
        'change_details_json', 'ip_address'
    ];
    protected $useTimestamps    = false;

    public function record(int $adminId, string $action, string $entity, ?int $entityId = null, ?array $details = null): void
    {
        $this->insert([
            'admin_user_id'       => $adminId,
            'action'              => $action,
            'entity_name'         => $entity,
            'entity_id'           => $entityId,
            'change_details_json' => $details ? json_encode($details, JSON_UNESCAPED_UNICODE) : null,
            'ip_address'          => service('request')->getIPAddress(),
            'created_at'          => date('Y-m-d H:i:s'),
        ]);
    }
}
