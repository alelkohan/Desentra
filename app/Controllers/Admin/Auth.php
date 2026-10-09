<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;
use App\Models\AdminAuditLogModel;

class Auth extends BaseController
{
    protected $adminModel;
    protected $auditModel;

    public function __construct()
    {
        $this->adminModel = new AdminUserModel();
        $this->auditModel = new AdminAuditLogModel();
    }

    public function login()
    {
        if (session('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return view('admin/auth/login', [
            'title' => 'Login Petugas Desa - Desentra Admin'
        ]);
    }

    public function attemptLogin()
    {
        $rules = [
            'login'    => 'required|min_length[3]',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Silakan masukkan username/email dan password.');
        }

        $login = trim($this->request->getPost('login'));
        $password = $this->request->getPost('password');

        $user = $this->adminModel->findByCredentials($login);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Akun admin tidak ditemukan.');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()->withInput()->with('error', 'Akun admin ini berstatus nonaktif.');
        }

        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Password yang Anda masukkan salah.');
        }

        // Set session
        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => (int) $user['id'],
            'admin_username'  => $user['username'],
            'admin_name'      => $user['full_name'],
            'admin_email'     => $user['email'],
            'admin_role'      => $user['role'],
        ]);

        // Update last login
        $this->adminModel->update($user['id'], [
            'last_login_at' => date('Y-m-d H:i:s'),
        ]);

        // Record audit
        $this->auditModel->record($user['id'], 'LOGIN', 'admin_users', $user['id'], [
            'role' => $user['role'],
            'time' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Selamat bertugas, ' . $user['full_name']);
    }

    public function logout()
    {
        if (session('admin_id')) {
            $this->auditModel->record((int) session('admin_id'), 'LOGOUT', 'admin_users', (int) session('admin_id'));
        }

        session()->remove(['admin_logged_in', 'admin_id', 'admin_username', 'admin_name', 'admin_email', 'admin_role']);
        session()->setFlashdata('success', 'Anda telah berhasil keluar dari Panel Admin.');

        return redirect()->to(base_url('admin/login'));
    }
}
