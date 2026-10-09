<?php

namespace App\Controllers;

use App\Models\ComplaintModel;
use App\Models\ComplaintAttachmentModel;
use App\Models\ComplaintStatusHistoryModel;

class Pengaduan extends BaseController
{
    protected $complaintModel;

    public function __construct()
    {
        $this->complaintModel = new ComplaintModel();
    }

    public function index(): string
    {
        $data = [
            'title'     => 'Kanal Pengaduan & Masukan Warga - Desentra',
            'activeNav' => 'pengaduan',
            'errors'    => session()->getFlashdata('errors') ?? [],
            'ticket'    => session()->getFlashdata('ticket') ?? null,
        ];

        return view('warga/pengaduan/index', $data);
    }

    public function submit()
    {
        $rules = [
            'title'       => 'required|min_length[5]|max_length[200]',
            'category'    => 'required|in_list[layanan,infrastruktur,kebersihan,administrasi,lainnya]',
            'description' => 'required|min_length[10]|max_length[3000]',
            'contact'     => 'permit_empty|max_length[100]',
            'photo'       => 'permit_empty|uploaded[photo]|max_size[photo,5120]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $ticketCode = ComplaintModel::generateTicketCode();

        $complaintData = [
            'ticket_code'   => $ticketCode,
            'title'         => $this->request->getPost('title'),
            'category'      => $this->request->getPost('category'),
            'description'   => $this->request->getPost('description'),
            'contact_reply' => $this->request->getPost('contact') ?: null,
            'status'        => 'received',
        ];

        $this->complaintModel->insert($complaintData);
        $complaintId = $this->complaintModel->getInsertID();

        // Handle upload foto lampiran jika ada
        $file = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/pengaduan', $newName);

            $attachmentModel = new ComplaintAttachmentModel();
            $attachmentModel->insert([
                'complaint_id' => $complaintId,
                'file_path'    => 'uploads/pengaduan/' . $newName,
                'file_name'    => $file->getClientName(),
                'file_size'    => $file->getSize(),
                'mime_type'    => $file->getClientMimeType(),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        // Catat initial history status
        $historyModel = new ComplaintStatusHistoryModel();
        $historyModel->insert([
            'complaint_id'        => $complaintId,
            'status'              => 'received',
            'public_note'         => 'Pengaduan Anda telah berhasil dicatat oleh sistem Desentra.',
            'internal_note'       => 'Pengaduan dikirim melalui portal mobile warga.',
            'updated_by_admin_id' => null,
            'created_at'          => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('pengaduan/status/' . $ticketCode))
                         ->with('ticket_created', true)
                         ->with('ticket_code', $ticketCode);
    }

    public function status($ticketCode = null): string
    {
        $code = $ticketCode ?: $this->request->getGet('tiket');
        $complaint = null;

        if ($code) {
            $complaint = $this->complaintModel->getComplaintByTicket($code);
        }

        $data = [
            'title'         => 'Cek Status Pengaduan - Desentra',
            'activeNav'     => 'pengaduan',
            'ticketCode'    => $code,
            'complaint'     => $complaint,
            'ticketCreated' => session()->getFlashdata('ticket_created') ?? false,
        ];

        return view('warga/pengaduan/status', $data);
    }
}
