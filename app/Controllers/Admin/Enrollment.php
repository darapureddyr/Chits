<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;
use App\Models\PlanModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Enrollment extends BaseController
{
    /* =========================
       ADMIN PROTECTION
    ========================= */
    private function protect()
    {
        if (!session()->get('admin_logged_in')) {
            redirect()->to(base_url('admin/login'))->send();
            exit;
        }
    }

    /* =========================
       ENROLLMENTS BY PLAN
    ========================= */
    public function index($planId)
    {
        $this->protect();

        $planModel   = new PlanModel();
        $enrollModel = new EnrollmentModel();

        // ✅ Validate plan
        $plan = $planModel->find($planId);
        if (!$plan) {
            throw new PageNotFoundException('Plan not found');
        }

        // ✅ Fetch enrollments (grouped per user)
        $enrollments = $enrollModel
            ->select('
                users.id AS user_id,
                users.name AS user_name,
                users.mobile,
                COUNT(enrollments.id) AS slots_taken,
                MIN(enrollments.enrolled_at) AS first_enrolled_at
            ')
            ->join('users', 'users.id = enrollments.user_id')
            ->where('enrollments.plan_id', $planId)
            ->groupBy('users.id')
            ->orderBy('first_enrolled_at', 'ASC')
            ->findAll();

        // ✅ Total filled slots
        $totalFilled = $enrollModel
            ->where('plan_id', $planId)
            ->countAllResults();

        return view('admin/enrollments/index', [
            'title'        => 'Plan Enrollments',
            'activePage'   => 'plans',
            'plan'         => $plan,
            'enrollments'  => $enrollments,
            'totalFilled'  => $totalFilled
        ]);
    }
}
