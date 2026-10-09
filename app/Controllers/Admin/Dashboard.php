<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceGuideModel;
use App\Models\VillageInfoModel;
use App\Models\ComplaintModel;
use App\Models\ResidentQuestionModel;
use App\Models\AdminAuditLogModel;

class Dashboard extends BaseController
{
    protected $guideModel;
    protected $infoModel;
    protected $complaintModel;
    protected $questionModel;
    protected $auditModel;

    public function __construct()
    {
        $this->guideModel     = new ServiceGuideModel();
        $this->infoModel      = new VillageInfoModel();
        $this->complaintModel = new ComplaintModel();
        $this->questionModel  = new ResidentQuestionModel();
        $this->auditModel     = new AdminAuditLogModel();
    }

    public function index()
    {
        // Metric 1: Panduan Layanan
        $totalGuides     = $this->guideModel->countAllResults();
        $publishedGuides = $this->guideModel->where('status', 'published')->countAllResults();
        $pendingGuides   = $this->guideModel->where('status', 'pending_verification')->countAllResults();
        $draftGuides     = $this->guideModel->where('status', 'draft')->countAllResults();

        // Metric 2: Info Desa
        $totalInfos  = $this->infoModel->countAllResults();
        $activeInfos = count($this->infoModel->getActiveInfos());

        // Metric 3: Pengaduan
        $totalComplaints    = $this->complaintModel->countAllResults();
        $receivedComplaints = $this->complaintModel->where('status', 'received')->countAllResults();
        $progressComplaints = $this->complaintModel->where('status', 'in_progress')->countAllResults();
        $resolvedComplaints = $this->complaintModel->where('status', 'resolved')->countAllResults();

        // Metric 4: AI RAG & Fallback
        $totalQuestions    = $this->questionModel->countAllResults();
        $fallbackQuestions = $this->questionModel->where('is_fallback', 1)->where('status !=', 'resolved')->countAllResults();

        // Recent Complaints needing review
        $pendingComplaintsList = $this->complaintModel->whereIn('status', ['received', 'in_review'])
                                                      ->orderBy('created_at', 'DESC')
                                                      ->limit(3)
                                                      ->findAll();

        // Recent Guides needing verification
        $pendingGuidesList = $this->guideModel->where('status', 'pending_verification')
                                              ->orderBy('updated_at', 'DESC')
                                              ->limit(3)
                                              ->findAll();

        // Recent Audit Activity
        $recentAudits = $this->auditModel->select('admin_audit_logs.*, admin_users.full_name as admin_name')
                                         ->join('admin_users', 'admin_users.id = admin_audit_logs.admin_user_id', 'left')
                                         ->orderBy('admin_audit_logs.created_at', 'DESC')
                                         ->limit(5)
                                         ->findAll();

        $data = [
            'title'                 => 'Dashboard Statistik - Desentra Admin',
            'activeTab'             => 'dashboard',
            'stats'                 => [
                'totalGuides'        => $totalGuides,
                'publishedGuides'    => $publishedGuides,
                'pendingGuides'      => $pendingGuides,
                'draftGuides'        => $draftGuides,
                'totalInfos'         => $totalInfos,
                'activeInfos'        => $activeInfos,
                'totalComplaints'    => $totalComplaints,
                'receivedComplaints' => $receivedComplaints,
                'progressComplaints' => $progressComplaints,
                'resolvedComplaints' => $resolvedComplaints,
                'totalQuestions'     => $totalQuestions,
                'fallbackQuestions'  => $fallbackQuestions,
            ],
            'pendingComplaintsList' => $pendingComplaintsList,
            'pendingGuidesList'     => $pendingGuidesList,
            'recentAudits'          => $recentAudits,
        ];

        return view('admin/dashboard/index', $data);
    }
}
