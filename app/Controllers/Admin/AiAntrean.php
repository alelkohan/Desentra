<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ResidentQuestionModel;
use App\Models\AdminAuditLogModel;

class AiAntrean extends BaseController
{
    protected $questionModel;
    protected $auditModel;

    public function __construct()
    {
        $this->questionModel = new ResidentQuestionModel();
        $this->auditModel    = new AdminAuditLogModel();
    }

    public function index()
    {
        $filter = $this->request->getGet('tab') ?? 'pending';
        $search = trim($this->request->getGet('q') ?? '');

        $builder = $this->questionModel->builder();

        if ($filter === 'pending') {
            $builder->where('is_fallback', 1)
                    ->where('status !=', 'resolved');
        } elseif ($filter === 'resolved') {
            $builder->where('status', 'resolved');
        }

        if ($search !== '') {
            $builder->groupStart()
                    ->like('question_text', $search)
                    ->orLike('answer_text', $search)
                    ->groupEnd();
        }

        $builder->orderBy('created_at', 'DESC');
        $questions = $builder->get()->getResultArray();

        $counts = [
            'pending'  => $this->questionModel->where('is_fallback', 1)->where('status !=', 'resolved')->countAllResults(),
            'all'      => $this->questionModel->countAllResults(),
            'resolved' => $this->questionModel->where('status', 'resolved')->countAllResults(),
        ];

        return view('admin/ai_antrean/index', [
            'title'     => 'Antrean Review AI & Fallback - Desentra Admin',
            'activeTab' => 'ai_antrean',
            'questions' => $questions,
            'currentTab'=> $filter,
            'search'    => $search,
            'counts'    => $counts,
            'userRole'  => session('admin_role'),
        ]);
    }

    public function resolve($id)
    {
        $q = $this->questionModel->find($id);
        if (!$q) {
            return redirect()->back()->with('error', 'Pertanyaan tidak ditemukan.');
        }

        $this->questionModel->update($id, [
            'status' => 'resolved',
        ]);

        $this->auditModel->record((int) session('admin_id'), 'RESOLVE_AI_QUESTION', 'resident_questions', $id, [
            'question_text' => $q['question_text'],
        ]);

        return redirect()->back()->with('success', 'Pertanyaan AI telah ditandai selesai/diarsipkan.');
    }
}
