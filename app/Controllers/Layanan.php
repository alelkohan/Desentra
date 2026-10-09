<?php

namespace App\Controllers;

use App\Models\ServiceGuideModel;

class Layanan extends BaseController
{
    protected $guideModel;

    public function __construct()
    {
        $this->guideModel = new ServiceGuideModel();
    }

    public function index(): string
    {
        $category = $this->request->getGet('kategori') ?? 'all';
        $search   = $this->request->getGet('q');

        $guides = $this->guideModel->getPublishedGuides(null, $category, $search);

        $dbCategories = $this->guideModel->where('status', 'published')
                                         ->select('category')
                                         ->distinct()
                                         ->orderBy('category', 'ASC')
                                         ->findColumn('category') ?? [];

        $categories = ['all' => 'Semua'];
        foreach ($dbCategories as $cat) {
            if (!empty($cat)) {
                $categories[$cat] = $cat;
            }
        }


        $data = [
            'title'          => 'Katalog Layanan Desa - Desentra',
            'activeNav'      => 'layanan',
            'guides'         => $guides,
            'currentCategory'=> $category,
            'searchQuery'    => $search,
            'categories'     => $categories,
        ];

        return view('warga/layanan/index', $data);
    }

    public function detail($slug)
    {
        $guide = $this->guideModel->getGuideWithDetails($slug);

        if (!$guide) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Panduan layanan tidak ditemukan');
        }

        $steps = json_decode($guide['steps_json'] ?? '[]', true);

        $data = [
            'title'     => $guide['title'] . ' - Desentra',
            'activeNav' => 'layanan',
            'guide'     => $guide,
            'steps'     => $steps,
        ];

        return view('warga/layanan/detail', $data);
    }
}
