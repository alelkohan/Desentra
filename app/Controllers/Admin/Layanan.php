<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceGuideModel;
use App\Models\GuideRequirementModel;
use App\Models\GuideChunkModel;
use App\Models\ResidentQuestionModel;
use App\Models\AdminAuditLogModel;

class Layanan extends BaseController
{
    protected $guideModel;
    protected $reqModel;
    protected $chunkModel;
    protected $auditModel;

    public function __construct()
    {
        $this->guideModel = new ServiceGuideModel();
        $this->reqModel   = new GuideRequirementModel();
        $this->chunkModel = new GuideChunkModel();
        $this->auditModel = new AdminAuditLogModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status') ?? 'all';
        $search = trim($this->request->getGet('q') ?? '');

        $builder = $this->guideModel->builder();

        if ($status !== 'all' && in_array($status, ['draft', 'pending_verification', 'published', 'needs_review', 'archived'])) {
            $builder->where('status', $status);
        }

        if ($search !== '') {
            $builder->groupStart()
                    ->like('title', $search)
                    ->orLike('category', $search)
                    ->orLike('summary', $search)
                    ->groupEnd();
        }

        $builder->orderBy('updated_at', 'DESC');
        $guides = $builder->get()->getResultArray();

        // Status counts for filter pills
        $counts = [
            'all'                  => $this->guideModel->countAllResults(),
            'published'            => $this->guideModel->where('status', 'published')->countAllResults(),
            'pending_verification' => $this->guideModel->where('status', 'pending_verification')->countAllResults(),
            'draft'                => $this->guideModel->where('status', 'draft')->countAllResults(),
            'needs_review'         => $this->guideModel->where('status', 'needs_review')->countAllResults(),
        ];

        return view('admin/layanan/index', [
            'title'        => 'Manajemen Panduan Layanan - Desentra Admin',
            'activeTab'    => 'layanan',
            'guides'       => $guides,
            'currentStatus'=> $status,
            'search'       => $search,
            'counts'       => $counts,
            'userRole'     => session('admin_role'),
        ]);
    }

    public function create()
    {
        $prefillTitle = trim($this->request->getGet('title') ?? '');
        $fromQuestionId = (int) $this->request->getGet('from_q');

        return view('admin/layanan/form', [
            'title'          => 'Tambah Panduan Baru - Desentra Admin',
            'activeTab'      => 'layanan',
            'guide'          => null,
            'requirements'   => [],
            'prefillTitle'   => $prefillTitle,
            'fromQuestionId' => $fromQuestionId,
            'userRole'       => session('admin_role'),
        ]);
    }

    public function store()
    {
        $role = session('admin_role');
        $title = trim($this->request->getPost('title') ?? '');
        $category = trim($this->request->getPost('category') ?? 'Kependudukan');
        $summary = trim($this->request->getPost('summary') ?? '');
        $description = trim($this->request->getPost('description') ?? '');
        $estimatedDuration = trim($this->request->getPost('estimated_duration') ?? '1 hari kerja');
        $feeDescription = trim($this->request->getPost('fee_description') ?? 'Gratis');
        $status = $this->request->getPost('status') ?? 'draft';

        if (empty($title) || empty($summary)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Ringkasan Layanan wajib diisi.');
        }

        // Role restriction for status
        if ($role === 'editor' && $status === 'published') {
            $status = 'pending_verification'; // Editor can only submit for review
        }

        // Generate slug
        $baseSlug = url_title($title, '-', true);
        $slug = $baseSlug;
        $counter = 1;
        while ($this->guideModel->where('slug', $slug)->first()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Parse procedural steps from array
        $stepTitles = $this->request->getPost('step_titles') ?? [];
        $stepDescs  = $this->request->getPost('step_descriptions') ?? [];
        $steps = [];
        for ($i = 0; $i < count($stepTitles); $i++) {
            $stTitle = trim($stepTitles[$i] ?? '');
            $stDesc  = trim($stepDescs[$i] ?? '');
            if (!empty($stTitle) || !empty($stDesc)) {
                $steps[] = [
                    'step'        => count($steps) + 1,
                    'title'       => $stTitle,
                    'description' => $stDesc,
                ];
            }
        }

        $now = date('Y-m-d H:i:s');
        $adminId = (int) session('admin_id');

        $data = [
            'slug'               => $slug,
            'title'              => $title,
            'category'           => $category,
            'summary'            => $summary,
            'description'        => $description,
            'steps_json'         => json_encode($steps, JSON_UNESCAPED_UNICODE),
            'estimated_duration' => $estimatedDuration,
            'fee_description'    => $feeDescription,
            'icon'               => 'document',
            'status'             => $status,
            'created_by'         => $adminId,
            'checked_at'         => ($status === 'published') ? $now : null,
            'published_at'       => ($status === 'published') ? $now : null,
            'verified_by'        => ($status === 'published') ? $adminId : null,
        ];

        $guideId = $this->guideModel->insert($data);

        if (!$guideId) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan panduan.');
        }

        // Save requirements
        $reqTitles = $this->request->getPost('req_titles') ?? [];
        $reqDescs  = $this->request->getPost('req_descriptions') ?? [];
        $reqMandatory = $this->request->getPost('req_mandatory') ?? [];

        for ($i = 0; $i < count($reqTitles); $i++) {
            $rTitle = trim($reqTitles[$i] ?? '');
            if (!empty($rTitle)) {
                $this->reqModel->insert([
                    'guide_id'       => $guideId,
                    'title'          => $rTitle,
                    'description'    => trim($reqDescs[$i] ?? ''),
                    'is_mandatory'   => isset($reqMandatory[$i]) ? 1 : 0,
                    'order_position' => $i + 1,
                    'created_at'     => $now,
                ]);
            }
        }

        // Sync RAG chunk
        $this->chunkModel->syncGuideChunk($guideId);

        // If created from AI fallback question queue, resolve it
        $fromQ = (int) $this->request->getPost('from_question_id');
        if ($fromQ > 0) {
            $qModel = new ResidentQuestionModel();
            $qModel->update($fromQ, ['status' => 'resolved']);
        }

        // Audit Log
        $this->auditModel->record($adminId, 'CREATE_GUIDE', 'service_guides', $guideId, [
            'title'  => $title,
            'status' => $status,
        ]);

        $msg = ($status === 'published') 
            ? 'Panduan berhasil diterbitkan dan otomatis diindeks ke AI!' 
            : (($status === 'pending_verification') ? 'Panduan diajukan untuk verifikasi.' : 'Draf panduan berhasil disimpan.');

        return redirect()->to(base_url('admin/layanan'))->with('success', $msg);
    }

    public function edit($id)
    {
        $guide = $this->guideModel->find($id);
        if (!$guide) {
            return redirect()->to(base_url('admin/layanan'))->with('error', 'Panduan tidak ditemukan.');
        }

        $requirements = $this->reqModel->where('guide_id', $id)->orderBy('order_position', 'ASC')->findAll();

        return view('admin/layanan/form', [
            'title'          => 'Edit Panduan - ' . esc($guide['title']),
            'activeTab'      => 'layanan',
            'guide'          => $guide,
            'requirements'   => $requirements,
            'prefillTitle'   => '',
            'fromQuestionId' => 0,
            'userRole'       => session('admin_role'),
        ]);
    }

    public function update($id)
    {
        $guide = $this->guideModel->find($id);
        if (!$guide) {
            return redirect()->to(base_url('admin/layanan'))->with('error', 'Panduan tidak ditemukan.');
        }

        $role = session('admin_role');
        $title = trim($this->request->getPost('title') ?? '');
        $category = trim($this->request->getPost('category') ?? 'Kependudukan');
        $summary = trim($this->request->getPost('summary') ?? '');
        $description = trim($this->request->getPost('description') ?? '');
        $estimatedDuration = trim($this->request->getPost('estimated_duration') ?? '1 hari kerja');
        $feeDescription = trim($this->request->getPost('fee_description') ?? 'Gratis');
        $status = $this->request->getPost('status') ?? $guide['status'];

        if (empty($title) || empty($summary)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Ringkasan Layanan wajib diisi.');
        }

        // Role restriction for status
        if ($role === 'editor' && $status === 'published' && $guide['status'] !== 'published') {
            $status = 'pending_verification';
        }

        // Parse steps
        $stepTitles = $this->request->getPost('step_titles') ?? [];
        $stepDescs  = $this->request->getPost('step_descriptions') ?? [];
        $steps = [];
        for ($i = 0; $i < count($stepTitles); $i++) {
            $stTitle = trim($stepTitles[$i] ?? '');
            $stDesc  = trim($stepDescs[$i] ?? '');
            if (!empty($stTitle) || !empty($stDesc)) {
                $steps[] = [
                    'step'        => count($steps) + 1,
                    'title'       => $stTitle,
                    'description' => $stDesc,
                ];
            }
        }

        $now = date('Y-m-d H:i:s');
        $adminId = (int) session('admin_id');

        $updateData = [
            'title'              => $title,
            'category'           => $category,
            'summary'            => $summary,
            'description'        => $description,
            'steps_json'         => json_encode($steps, JSON_UNESCAPED_UNICODE),
            'estimated_duration' => $estimatedDuration,
            'fee_description'    => $feeDescription,
            'status'             => $status,
        ];

        if ($status === 'published' && empty($guide['published_at'])) {
            $updateData['published_at'] = $now;
            $updateData['verified_by']  = $adminId;
            $updateData['checked_at']   = $now;
        }

        $this->guideModel->update($id, $updateData);

        // Sync requirements: delete old and insert new
        $this->reqModel->where('guide_id', $id)->delete();
        $reqTitles = $this->request->getPost('req_titles') ?? [];
        $reqDescs  = $this->request->getPost('req_descriptions') ?? [];
        $reqMandatory = $this->request->getPost('req_mandatory') ?? [];

        for ($i = 0; $i < count($reqTitles); $i++) {
            $rTitle = trim($reqTitles[$i] ?? '');
            if (!empty($rTitle)) {
                $this->reqModel->insert([
                    'guide_id'       => $id,
                    'title'          => $rTitle,
                    'description'    => trim($reqDescs[$i] ?? ''),
                    'is_mandatory'   => isset($reqMandatory[$i]) ? 1 : 0,
                    'order_position' => $i + 1,
                    'created_at'     => $now,
                ]);
            }
        }

        // Rebuild RAG chunk
        $this->chunkModel->syncGuideChunk($id);

        // Audit Log
        $this->auditModel->record($adminId, 'UPDATE_GUIDE', 'service_guides', $id, [
            'title'  => $title,
            'status' => $status,
        ]);

        return redirect()->to(base_url('admin/layanan'))->with('success', 'Perubahan panduan berhasil disimpan.');
    }

    public function changeStatus($id)
    {
        $guide = $this->guideModel->find($id);
        if (!$guide) {
            return redirect()->back()->with('error', 'Panduan tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status');
        $validStatuses = ['draft', 'pending_verification', 'published', 'needs_review', 'archived'];

        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $role = session('admin_role');

        if ($role === 'editor' && in_array($newStatus, ['published', 'archived'])) {
            return redirect()->back()->with('error', 'Peran Editor hanya dapat mengubah ke Draf atau Ajukan Verifikasi.');
        }

        $now = date('Y-m-d H:i:s');
        $adminId = (int) session('admin_id');

        $updateData = ['status' => $newStatus];
        if ($newStatus === 'published') {
            $updateData['published_at'] = $now;
            $updateData['verified_by']  = $adminId;
            $updateData['checked_at']   = $now;
        }

        $this->guideModel->update($id, $updateData);

        // Sync RAG chunk
        $this->chunkModel->syncGuideChunk($id);

        // Audit Log
        $this->auditModel->record($adminId, 'CHANGE_GUIDE_STATUS', 'service_guides', $id, [
            'from' => $guide['status'],
            'to'   => $newStatus,
        ]);

        return redirect()->back()->with('success', 'Status panduan berhasil diperbarui ke: ' . strtoupper($newStatus));
    }

    public function delete($id)
    {
        if (session('admin_role') !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Superadmin yang memiliki izin menghapus panduan.');
        }

        $guide = $this->guideModel->find($id);
        if (!$guide) {
            return redirect()->back()->with('error', 'Panduan tidak ditemukan.');
        }

        $this->reqModel->where('guide_id', $id)->delete();
        $this->chunkModel->where('guide_id', $id)->delete();
        $this->guideModel->delete($id);

        $this->auditModel->record((int) session('admin_id'), 'DELETE_GUIDE', 'service_guides', $id, [
            'title' => $guide['title'],
        ]);

        return redirect()->to(base_url('admin/layanan'))->with('success', 'Panduan "' . $guide['title'] . '" berhasil dihapus.');
    }
}
