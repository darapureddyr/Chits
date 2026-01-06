<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlanModel;

class Plan extends BaseController
{
    protected $planModel;

    public function __construct()
    {
        $this->planModel = new PlanModel();

        // 🔐 ADMIN AUTH (ENABLE LATER)
        // if (!session()->get('admin_logged_in')) {
        //     redirect()->to('/admin/login')->send();
        //     exit;
        // }
    }

    /* =========================
       LIST ALL PLANS
    ========================= */
    public function index()
    {
        $plans = $this->planModel->getAllPlans();

        return view('admin/plans/index', [
            'plans'      => $plans,
            'title'      => 'Plans',
            'activePage' => 'plans'
        ]);
    }

    /* =========================
       CREATE PLAN FORM
    ========================= */
    public function create()
    {
        return view('admin/plans/create');
    }

    /* =========================
       STORE PLAN
    ========================= */
    public function store()
    {
        $totalSlots        = (int) $this->request->getPost('total_slots');
        $commissionPerUser = (float) $this->request->getPost('commission_amount');

        $data = [
            'plan_name'                  => $this->request->getPost('plan_name'),
            'plan_code'                  => $this->request->getPost('plan_code'),
            'chit_amount'                => $this->request->getPost('chit_amount'),
            'total_slots'                => $totalSlots,
            'max_slots_per_user'         => $this->request->getPost('max_slots_per_user'),
            'commission_amount'          => $commissionPerUser,

            // ✅ IMPORTANT: TOTAL COMMISSION
            'total_commission_per_month' => $commissionPerUser * $totalSlots,

            'description'                => $this->request->getPost('description'),
            'status'                     => $this->request->getPost('status'),
        ];

        // 🔒 Duplicate plan code check
        if ($this->planModel->isPlanCodeExists($data['plan_code'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Plan code already exists');
        }

        $this->planModel->insert($data);

        return redirect()->to('/admin/plans')
            ->with('success', 'Plan created successfully');
    }

    /* =========================
       EDIT PLAN FORM
    ========================= */
    public function edit($id)
    {
        $plan = $this->planModel->getPlanById($id);

        if (!$plan) {
            return redirect()->to('/admin/plans');
        }

        return view('admin/plans/edit', [
            'plan' => $plan
        ]);
    }

    /* =========================
       UPDATE PLAN
    ========================= */
    public function update($id)
    {
        $plan = $this->planModel->getPlanById($id);

        if (!$plan) {
            return redirect()->to('/admin/plans');
        }

        $totalSlots        = (int) $this->request->getPost('total_slots');
        $commissionPerUser = (float) $this->request->getPost('commission_amount');

        $data = [
            'plan_name'                  => $this->request->getPost('plan_name'),
            'chit_amount'                => $this->request->getPost('chit_amount'),
            'total_slots'                => $totalSlots,
            'max_slots_per_user'         => $this->request->getPost('max_slots_per_user'),
            'commission_amount'          => $commissionPerUser,

            // ✅ IMPORTANT: RECALCULATE
            'total_commission_per_month' => $commissionPerUser * $totalSlots,

            'description'                => $this->request->getPost('description'),
            'status'                     => $this->request->getPost('status'),
        ];

        $this->planModel->update($id, $data);

        return redirect()->to('/admin/plans')
            ->with('success', 'Plan updated successfully');
    }

    /* =========================
       DELETE PLAN
    ========================= */
    public function delete($id)
    {
        $plan = $this->planModel->getPlanById($id);

        if (!$plan) {
            return redirect()->to('/admin/plans');
        }

        /*
         ⚠️ IMPORTANT:
         This will also delete:
         - enrollments
         - enrollment_logs
         (because of ON DELETE CASCADE)
        */
        $this->planModel->delete($id);

        return redirect()->to('/admin/plans')
            ->with('success', 'Plan deleted successfully');
    }
}
