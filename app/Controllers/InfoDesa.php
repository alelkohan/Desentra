<?php

namespace App\Controllers;

use App\Models\VillageInfoModel;

class InfoDesa extends BaseController
{
    protected $infoModel;

    public function __construct()
    {
        $this->infoModel = new VillageInfoModel();
    }

    public function index(): string
    {
        $category = $this->request->getGet('kategori') ?? 'all';
        
        // Ambil MAKSIMAL 4 info/berita desa terbaru secara global untuk Carousel (tidak terpengaruh filter)
        $carouselInfos = $this->infoModel->getActiveInfos('all', 4);
        
        // Seluruh data aktif untuk list feed/arsip di bawah carousel (bisa difilter via kategori)
        $allInfos = $this->infoModel->getActiveInfos('all');

        $categories = [
            'all'          => 'Semua',
            'announcement' => 'Pengumuman',
            'schedule'     => 'Jadwal Layanan',
            'agenda'       => 'Agenda Desa',
            'important'    => 'Penting',
        ];

        $data = [
            'title'           => 'Info Desa Sukamaju - Desentra',
            'activeNav'       => 'info_desa',
            'carouselInfos'   => $carouselInfos,
            'infos'           => $carouselInfos, // Selalu 4 data terbaru global untuk carousel
            'allInfos'        => $allInfos,      // Data lengkap untuk difilter di list bawah
            'currentCategory' => $category,
            'categories'      => $categories,
        ];

        return view('warga/info_desa/index', $data);
    }

    public function detail($slug)
    {
        $info = $this->infoModel->where('slug', $slug)
                                ->where('status', 'published')
                                ->first();

        if (!$info) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Informasi desa tidak ditemukan');
        }

        $data = [
            'title'     => $info['title'] . ' - Info Desa Desentra',
            'activeNav' => 'info_desa',
            'info'      => $info,
        ];

        return view('warga/info_desa/detail', $data);
    }
}
