<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlanModel;
use App\Models\EnrollmentModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    private function protect()
    {
        if (!session()->get('admin_logged_in')) {
            redirect()->to(base_url('admin/login'))->send();
            exit;
        }
    }

    public function index()
    {
        $this->protect();

        $planModel   = new PlanModel();
        $enrollModel = new EnrollmentModel();
        $userModel   = new UserModel();

        // 1️⃣ Total plans
        $totalPlans = $planModel->countAllResults();

        // 2️⃣ Open plans
        $openPlans = $planModel->where('status', 1)->countAllResults();

        // 3️⃣ Total slots filled
        $totalEnrollments = $enrollModel
            ->selectSum('slots_used')
            ->get()
            ->getRow()
            ->slots_used ?? 0;

        // 4️⃣ Total users
        $totalUsers = $userModel->countAllResults();

        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'stats' => [
                'totalPlans'       => $totalPlans,
                'openPlans'        => $openPlans,
                'totalEnrollments' => $totalEnrollments,
                'activeUsers'      => $totalUsers
            ]
        ]);
    }
}
