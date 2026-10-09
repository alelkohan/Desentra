<?php

namespace App\Controllers;

use App\Services\DesentraAiService;

class Tanya extends BaseController
{
    protected $aiService;

    public function __construct()
    {
        $this->aiService = new DesentraAiService();
    }

    public function index(): string
    {
        // Session ID untuk tamu jika belum ada
        $session = session();
        if (!$session->has('chat_session_id')) {
            $session->set('chat_session_id', bin2hex(random_bytes(16)));
        }

        $data = [
            'title'     => 'Tanya AI Desentra - Panduan Layanan Desa',
            'activeNav' => 'tanya',
            'sessionId' => $session->get('chat_session_id'),
            'suggestedQuestions' => [
                'Urus SKTM untuk beasiswa',
                'Syarat bikin akta kelahiran baru',
                'Jam buka kantor desa',
                'Berapa biaya pengurusan surat desa?',
            ]
        ];

        return view('warga/tanya/index', $data);
    }

    public function ask()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $question = $this->request->getPost('question');
        $session = session();
        $sessionId = $session->get('chat_session_id');

        $result = $this->aiService->ask($question, $sessionId);

        return $this->response->setJSON($result);
    }

    public function feedback()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false]);
        }

        $questionId = $this->request->getPost('question_id');
        $rating = $this->request->getPost('rating'); // 1 = helpful, -1 = not helpful
        $comment = $this->request->getPost('comment');

        if ($questionId) {
            $db = \Config\Database::connect();
            $db->table('question_feedback')->insert([
                'question_id' => $questionId,
                'rating'      => (int)$rating,
                'comment'     => $comment ? substr($comment, 0, 500) : null,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
