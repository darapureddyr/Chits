<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Login extends BaseController
{
    /* =========================
     * SHOW ADMIN LOGIN PAGE
     * ========================= */
    public function login()
    {
        // If admin already logged in → dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return view('admin/login', [
            'title' => 'Admin Login'
        ]);
    }

    /* =========================
     * ADMIN LOGIN POST
     * ========================= */
    public function loginPost()
    {
        $model = new AdminModel();

        // Sanitize input
        $mobile   = trim((string) $this->request->getPost('mobile'));
        $password = trim((string) $this->request->getPost('password'));

        if ($mobile === '' || $password === '') {
            return redirect()->back()
                ->with('error', 'Mobile and password are required')
                ->withInput();
        }

        // Find admin by mobile
        $admin = $model->where('mobile', $mobile)->first();

        // ✅ Verify password
        if ($admin && password_verify($password, $admin['password'])) {

            // ✅ CREATE ADMIN SESSION
            session()->set([
                'admin_logged_in' => true,
                'admin_id'        => $admin['id'],
                'admin_name'      => $admin['name']
            ]);

            return redirect()->to(base_url('admin/dashboard'));
        }

        // ❌ Invalid login
        return redirect()->back()
            ->with('error', 'Invalid login details')
            ->withInput();
    }

    /* =========================
     * ADMIN LOGOUT
     * ========================= */
    public function logout()
    {
        // Remove only admin session
        session()->remove([
            'admin_logged_in',
            'admin_id',
            'admin_name'
        ]);

        return redirect()->to(base_url('admin/login'));
    }
}
