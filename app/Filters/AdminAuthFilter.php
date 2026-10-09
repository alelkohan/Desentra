<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('admin_logged_in')) {
            $session->setFlashdata('error', 'Silakan login terlebih dahulu untuk mengakses Panel Admin.');
            return redirect()->to(base_url('admin/login'));
        }

        // If specific role requirement is passed in arguments
        if (!empty($arguments)) {
            $userRole = $session->get('admin_role');
            // Superadmin has all permissions
            if ($userRole !== 'admin' && !in_array($userRole, $arguments, true)) {
                $session->setFlashdata('error', 'Anda tidak memiliki hak akses untuk tindakan ini.');
                return redirect()->to(base_url('admin/dashboard'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
