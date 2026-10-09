<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ComplaintModel;
use App\Models\ComplaintStatusHistoryModel;
use App\Models\AdminAuditLogModel;

class Pengaduan extends BaseController
{
    protected $complaintModel;
    protected $historyModel;
    protected $auditModel;

    public function __construct()
    {
        $this->complaintModel = new ComplaintModel();
        $this->historyModel   = new ComplaintStatusHistoryModel();
        $this->auditModel     = new AdminAuditLogModel();
    }

    public function index()
    {
        $status   = $this->request->getGet('status') ?? 'all';
        $category = $this->request->getGet('category') ?? 'all';
        $search   = trim($this->request->getGet('q') ?? '');

        $builder = $this->complaintModel->builder();

        if ($status !== 'all' && in_array($status, ['received', 'in_review', 'in_progress', 'resolved', 'rejected'])) {
            $builder->where('status', $status);
        }

        if ($category !== 'all') {
            $builder->where('category', $category);
        }

        if ($search !== '') {
            $builder->groupStart()
                    ->like('ticket_code', $search)
                    ->orLike('title', $search)
                    ->orLike('contact_reply', $search)
                    ->groupEnd();
        }

        $builder->orderBy('created_at', 'DESC');
        $complaints = $builder->get()->getResultArray();

        $counts = [
            'all'         => $this->complaintModel->countAllResults(),
            'received'    => $this->complaintModel->where('status', 'received')->countAllResults(),
            'in_review'   => $this->complaintModel->where('status', 'in_review')->countAllResults(),
            'in_progress' => $this->complaintModel->where('status', 'in_progress')->countAllResults(),
            'resolved'    => $this->complaintModel->where('status', 'resolved')->countAllResults(),
            'rejected'    => $this->complaintModel->where('status', 'rejected')->countAllResults(),
        ];

        return view('admin/pengaduan/index', [
            'title'           => 'Kotak Pengaduan Warga - Desentra Admin',
            'activeTab'       => 'pengaduan',
            'complaints'      => $complaints,
            'currentStatus'   => $status,
            'currentCategory' => $category,
            'search'          => $search,
            'counts'          => $counts,
            'userRole'        => session('admin_role'),
        ]);
    }

    public function detail($id)
    {
        $complaint = $this->complaintModel->find($id);
        if (!$complaint) {
            return redirect()->to(base_url('admin/pengaduan'))->with('error', 'Tiket pengaduan tidak ditemukan.');
        }

        $db = \Config\Database::connect();

        // Ambil lampiran foto
        $attachments = $db->table('complaint_attachments')
                          ->where('complaint_id', $complaint['id'])
                          ->get()
                          ->getResultArray();

        // Ambil riwayat status & catatan petugas
        $history = $db->table('complaint_status_history')
                      ->select('complaint_status_history.*, admin_users.full_name as admin_name, admin_users.role as admin_role')
                      ->join('admin_users', 'admin_users.id = complaint_status_history.updated_by_admin_id', 'left')
                      ->where('complaint_id', $complaint['id'])
                      ->orderBy('complaint_status_history.created_at', 'ASC')
                      ->get()
                      ->getResultArray();

        return view('admin/pengaduan/detail', [
            'title'       => 'Tiket ' . esc($complaint['ticket_code']) . ' - Desentra Admin',
            'activeTab'   => 'pengaduan',
            'complaint'   => $complaint,
            'attachments' => $attachments,
            'history'     => $history,
            'userRole'    => session('admin_role'),
        ]);
    }

    public function updateStatus($id)
    {
        $complaint = $this->complaintModel->find($id);
        if (!$complaint) {
            return redirect()->back()->with('error', 'Tiket pengaduan tidak ditemukan.');
        }

        $newStatus    = $this->request->getPost('status');
        $publicNote   = trim($this->request->getPost('public_note') ?? '');
        $internalNote = trim($this->request->getPost('internal_note') ?? '');

        $validStatuses = ['received', 'in_review', 'in_progress', 'resolved', 'rejected'];
        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $adminId = (int) session('admin_id');
        $now     = date('Y-m-d H:i:s');

        // Update main complaint
        $this->complaintModel->update($id, [
            'status'     => $newStatus,
            'updated_at' => $now,
        ]);

        // Insert into history
        $this->historyModel->insert([
            'complaint_id'        => $id,
            'status'              => $newStatus,
            'public_note'         => $publicNote ?: null,
            'internal_note'       => $internalNote ?: null,
            'updated_by_admin_id' => $adminId,
            'created_at'          => $now,
        ]);

        // Audit Log
        $this->auditModel->record($adminId, 'UPDATE_COMPLAINT_STATUS', 'complaints', $id, [
            'ticket_code' => $complaint['ticket_code'],
            'from_status' => $complaint['status'],
            'to_status'   => $newStatus,
            'public_note' => $publicNote,
        ]);

        return redirect()->back()->with('success', 'Status tiket pengaduan berhasil diperbarui ke: ' . strtoupper($newStatus));
    }
}
