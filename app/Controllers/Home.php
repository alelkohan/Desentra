<?php

namespace App\Controllers;

use App\Models\ServiceGuideModel;
use App\Models\VillageInfoModel;

class Home extends BaseController
{
    public function index(): string
    {
        $guideModel = new ServiceGuideModel();
        $infoModel = new VillageInfoModel();

        $data = [
            'title'            => 'Desentra - Panduan Layanan Desa',
            'activeNav'        => 'beranda',
            'villageName'      => env('DESENTRA_VILLAGE_NAME', 'Desa Sukamaju'),
            'districtName'     => env('DESENTRA_DISTRICT_NAME', 'Kecamatan Ciawi'),
            'popularGuides'    => $guideModel->getPublishedGuides(4),
            'latestInfos'      => $infoModel->getActiveInfos(null, 3),
            'announcements'    => $infoModel->getActiveInfos('announcement', 2),
        ];

        return view('warga/beranda', $data);
    }
}
