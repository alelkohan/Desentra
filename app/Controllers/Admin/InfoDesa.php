<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VillageInfoModel;
use App\Models\AdminAuditLogModel;

class InfoDesa extends BaseController
{
    protected $infoModel;
    protected $auditModel;

    public function __construct()
    {
        $this->infoModel  = new VillageInfoModel();
        $this->auditModel = new AdminAuditLogModel();
    }

    public function index()
    {
        $category = $this->request->getGet('category') ?? 'all';
        $status   = $this->request->getGet('status') ?? 'all';
        $search   = trim($this->request->getGet('q') ?? '');

        $builder = $this->infoModel->builder();

        if ($category !== 'all') {
            $builder->where('category', $category);
        }

        if ($status !== 'all') {
            $builder->where('status', $status);
        }

        if ($search !== '') {
            $builder->groupStart()
                    ->like('title', $search)
                    ->orLike('content', $search)
                    ->groupEnd();
        }

        $builder->orderBy('published_at', 'DESC')
                ->orderBy('created_at', 'DESC');

        $infos = $builder->get()->getResultArray();

        $counts = [
            'all'          => $this->infoModel->countAllResults(),
            'announcement' => $this->infoModel->where('category', 'announcement')->countAllResults(),
            'schedule'     => $this->infoModel->where('category', 'schedule')->countAllResults(),
            'agenda'       => $this->infoModel->where('category', 'agenda')->countAllResults(),
            'important'    => $this->infoModel->where('category', 'important')->countAllResults(),
        ];

        return view('admin/info_desa/index', [
            'title'           => 'Manajemen Info Desa - Desentra Admin',
            'activeTab'       => 'info_desa',
            'infos'           => $infos,
            'currentCategory' => $category,
            'currentStatus'   => $status,
            'search'          => $search,
            'counts'          => $counts,
            'userRole'        => session('admin_role'),
        ]);
    }

    public function create()
    {
        return view('admin/info_desa/form', [
            'title'     => 'Tambah Pengumuman / Info Desa - Desentra Admin',
            'activeTab' => 'info_desa',
            'info'      => null,
            'userRole'  => session('admin_role'),
        ]);
    }

    public function store()
    {
        $title    = trim($this->request->getPost('title') ?? '');
        $category = trim($this->request->getPost('category') ?? 'announcement');
        $content  = trim($this->request->getPost('content') ?? '');
        $status   = $this->request->getPost('status') ?? 'published';
        $isPriority = $this->request->getPost('is_priority') ? 1 : 0;
        $validUntil = $this->request->getPost('valid_until');
        if (empty($validUntil)) {
            $validUntil = null;
        }

        if (empty($title) || empty($content)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Konten Info Desa wajib diisi.');
        }

        // Slug
        $baseSlug = url_title($title, '-', true);
        $slug = $baseSlug;
        $counter = 1;
        while ($this->infoModel->where('slug', $slug)->first()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Poster image handling
        $bannerImage = 'poster-default.png';
        $presetBanner = $this->request->getPost('preset_banner');
        if (!empty($presetBanner)) {
            $bannerImage = $presetBanner;
        }

        $file = $this->request->getFile('banner_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = $file->getClientExtension();
            $newName = 'info_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $file->move(FCPATH . 'img', $newName);
            $bannerImage = $newName;
        }

        $now = date('Y-m-d H:i:s');
        $adminId = (int) session('admin_id');

        $data = [
            'slug'         => $slug,
            'title'        => $title,
            'category'     => $category,
            'content'      => $content,
            'banner_image' => $bannerImage,
            'is_priority'  => $isPriority,
            'valid_until'  => $validUntil,
            'status'       => $status,
            'created_by'   => $adminId,
            'verified_by'  => $adminId,
            'published_at' => ($status === 'published') ? $now : null,
        ];

        $infoId = $this->infoModel->insert($data);

        // Audit Log
        $this->auditModel->record($adminId, 'CREATE_INFO', 'village_infos', $infoId, [
            'title'    => $title,
            'category' => $category,
        ]);

        return redirect()->to(base_url('admin/info-desa'))->with('success', 'Info desa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $info = $this->infoModel->find($id);
        if (!$info) {
            return redirect()->to(base_url('admin/info-desa'))->with('error', 'Info desa tidak ditemukan.');
        }

        return view('admin/info_desa/form', [
            'title'     => 'Edit Info Desa - ' . esc($info['title']),
            'activeTab' => 'info_desa',
            'info'      => $info,
            'userRole'  => session('admin_role'),
        ]);
    }

    public function update($id)
    {
        $info = $this->infoModel->find($id);
        if (!$info) {
            return redirect()->to(base_url('admin/info-desa'))->with('error', 'Info desa tidak ditemukan.');
        }

        $title    = trim($this->request->getPost('title') ?? '');
        $category = trim($this->request->getPost('category') ?? 'announcement');
        $content  = trim($this->request->getPost('content') ?? '');
        $status   = $this->request->getPost('status') ?? $info['status'];
        $isPriority = $this->request->getPost('is_priority') ? 1 : 0;
        $validUntil = $this->request->getPost('valid_until');
        if (empty($validUntil)) {
            $validUntil = null;
        }

        if (empty($title) || empty($content)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Konten Info Desa wajib diisi.');
        }

        $bannerImage = $info['banner_image'];
        $presetBanner = $this->request->getPost('preset_banner');
        if (!empty($presetBanner)) {
            $bannerImage = $presetBanner;
        }

        $file = $this->request->getFile('banner_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = $file->getClientExtension();
            $newName = 'info_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $file->move(FCPATH . 'img', $newName);
            $bannerImage = $newName;
        }

        $adminId = (int) session('admin_id');

        $updateData = [
            'title'        => $title,
            'category'     => $category,
            'content'      => $content,
            'banner_image' => $bannerImage,
            'is_priority'  => $isPriority,
            'valid_until'  => $validUntil,
            'status'       => $status,
        ];

        if ($status === 'published' && empty($info['published_at'])) {
            $updateData['published_at'] = date('Y-m-d H:i:s');
        }

        $this->infoModel->update($id, $updateData);

        // Audit Log
        $this->auditModel->record($adminId, 'UPDATE_INFO', 'village_infos', $id, [
            'title' => $title,
        ]);

        return redirect()->to(base_url('admin/info-desa'))->with('success', 'Perubahan info desa berhasil disimpan.');
    }

    public function delete($id)
    {
        $info = $this->infoModel->find($id);
        if (!$info) {
            return redirect()->back()->with('error', 'Info desa tidak ditemukan.');
        }

        $this->infoModel->delete($id);

        $this->auditModel->record((int) session('admin_id'), 'DELETE_INFO', 'village_infos', $id, [
            'title' => $info['title'],
        ]);

        return redirect()->to(base_url('admin/info-desa'))->with('success', 'Info desa berhasil dihapus.');
    }
}
