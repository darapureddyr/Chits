<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
       // shows login and regis form view folder inside authfolder name auth.php
       
       public function index()
{     if (session()->get('user_logged_in')) {
        return redirect()->to('/');
    }
    return view('frontend/auth/auth'); // ONE PAGE
}

    /* =========================
     * GENERATE ACCOUNT NUMBER (6 DIGITS)
     * Example: 500001, 500002
     * ========================= */
    private function generateUserCode()
    {
        $model = new UserModel();

        $last = $model->orderBy('id', 'DESC')->first();

        $num = $last
            ? (int) $last['user_code'] + 1
            : 500001;

        return (string) $num; // financial account number
    }

    /* =========================
     * REGISTER USER
     * ========================= */
    public function registerPost()
    {
        $model = new UserModel();

        // Mandatory fields check
        if (
            !$this->request->getPost('first_name') ||
            !$this->request->getPost('last_name') ||
            !$this->request->getPost('mobile') ||
            !$this->request->getPost('password')
        ) {
            return redirect()->back()
                ->with('error', 'All fields are mandatory');
        }

        // Prevent duplicate mobile
        if ($model->where('mobile', $this->request->getPost('mobile'))->first()) {
            return redirect()->back()
                ->with('error', 'Mobile number already registered');
        }

        // Generate account number
        $userCode = $this->generateUserCode();

        // Save user
        $model->insert([
            'user_code'  => $userCode,
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'mobile'     => $this->request->getPost('mobile'),
            'password'   => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            )
        ]);

        /*
         * IMPORTANT: User must remember account number
         */
        return redirect()->to('/auth')
            ->with(
                'success',
                "Registration successful. Your Account Number is <b>$userCode</b>. Please keep it safe."
            )
              ->with('show_login', true);;
    }

    /* =========================
     * LOGIN USER
     * ========================= */
    public function loginPost()
    {
        $model = new UserModel();

        // Find user by Account Number
        $user = $model->where(
            'user_code',
            $this->request->getPost('user_code')
        )->first();

        if (
            !$user ||
            !password_verify(
                $this->request->getPost('password'),
                $user['password']
            )
        ) {
            return redirect()->back()
                ->with('error', 'Invalid Account Number or Password');
        }

        // Login success
        session()->set([
            'user_logged_in' => true,
            'user_id'        => $user['id'],
            'user_name'      => $user['first_name']
        ]);

        /*
         * 🔁 Redirect back to join flow if exists
         */
        if (session()->get('redirect_after_login')) {
            $redirect = session()->get('redirect_after_login');
            session()->remove('redirect_after_login');
            return redirect()->to($redirect);
        }

        // Default redirect
        return redirect()->to('/');
    }

    /* =========================
     * LOGOUT USER
     * ========================= */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
