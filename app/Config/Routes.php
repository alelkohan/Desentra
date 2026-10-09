<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// 1. Beranda
$routes->get('/', 'Home::index');

// 2. Modul Layanan
$routes->get('layanan', 'Layanan::index');
$routes->get('layanan/detail/(:segment)', 'Layanan::detail/$1');

// 3. Modul Tanya (AI RAG)
$routes->get('tanya', 'Tanya::index');
$routes->post('tanya/ask', 'Tanya::ask');
$routes->post('tanya/feedback', 'Tanya::feedback');

// 4. Modul Pengaduan
$routes->get('pengaduan', 'Pengaduan::index');
$routes->post('pengaduan/submit', 'Pengaduan::submit');
$routes->get('pengaduan/status', 'Pengaduan::status');
$routes->get('pengaduan/status/(:segment)', 'Pengaduan::status/$1');

// 5. Modul Info Desa
$routes->get('info-desa', 'InfoDesa::index');
$routes->get('info-desa/detail/(:segment)', 'InfoDesa::detail/$1');

// ==================== PANEL ADMIN DESA ====================
// Auth Public Routes
$routes->get('admin', 'Admin\Auth::login');
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/login', 'Admin\Auth::attemptLogin');
$routes->get('admin/logout', 'Admin\Auth::logout');

// Protected Admin Routes Group
$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    // 1. Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // 2. Panduan Layanan (RAG Knowledge)
    $routes->get('layanan', 'Admin\Layanan::index');
    $routes->get('layanan/create', 'Admin\Layanan::create');
    $routes->post('layanan/store', 'Admin\Layanan::store');
    $routes->get('layanan/edit/(:num)', 'Admin\Layanan::edit/$1');
    $routes->post('layanan/update/(:num)', 'Admin\Layanan::update/$1');
    $routes->post('layanan/status/(:num)', 'Admin\Layanan::changeStatus/$1');
    $routes->post('layanan/delete/(:num)', 'Admin\Layanan::delete/$1');

    // 3. Info Desa & Pengumuman
    $routes->get('info-desa', 'Admin\InfoDesa::index');
    $routes->get('info-desa/create', 'Admin\InfoDesa::create');
    $routes->post('info-desa/store', 'Admin\InfoDesa::store');
    $routes->get('info-desa/edit/(:num)', 'Admin\InfoDesa::edit/$1');
    $routes->post('info-desa/update/(:num)', 'Admin\InfoDesa::update/$1');
    $routes->post('info-desa/delete/(:num)', 'Admin\InfoDesa::delete/$1');

    // 4. Pengaduan Warga
    $routes->get('pengaduan', 'Admin\Pengaduan::index');
    $routes->get('pengaduan/detail/(:num)', 'Admin\Pengaduan::detail/$1');
    $routes->post('pengaduan/status/(:num)', 'Admin\Pengaduan::updateStatus/$1');

    // 5. Antrean AI (Review Fallback)
    $routes->get('ai-antrean', 'Admin\AiAntrean::index');
    $routes->post('ai-antrean/resolve/(:num)', 'Admin\AiAntrean::resolve/$1');
});

