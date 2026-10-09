<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplaintModel extends Model
{
    protected $table            = 'complaints';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ticket_code', 'resident_user_id', 'title', 'category', 
        'description', 'contact_reply', 'status'
    ];
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public static function generateTicketCode()
    {
        $date = date('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 4));
        return 'DSN-' . $date . '-' . $random;
    }

    public function getComplaintByTicket($ticketCode)
    {
        $complaint = $this->where('ticket_code', strtoupper(trim($ticketCode)))->first();
        if (!$complaint) {
            return null;
        }

        $db = \Config\Database::connect();
        $complaint['attachments'] = $db->table('complaint_attachments')
                                       ->where('complaint_id', $complaint['id'])
                                       ->get()
                                       ->getResultArray();

        $complaint['history'] = $db->table('complaint_status_history')
                                   ->where('complaint_id', $complaint['id'])
                                   ->orderBy('created_at', 'ASC')
                                   ->get()
                                   ->getResultArray();

        return $complaint;
    }
}
