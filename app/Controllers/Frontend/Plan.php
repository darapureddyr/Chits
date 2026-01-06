<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PlanModel;
use App\Models\EnrollmentModel;

class Plan extends BaseController
{
    public function view($planId)
    {
        $planModel   = new PlanModel();
        $enrollModel = new EnrollmentModel();

        // 1️⃣ Load plan (open / running / full)
        $plan = $planModel->getActivePlan($planId);

        if (!$plan) {
            return redirect()->to('/');
        }

        // 2️⃣ Total slots filled in this plan
        $totalFilled = $enrollModel->getTotalSlotsFilled($planId);

        $slotsRemaining = max(
            0,
            $plan['total_slots'] - $totalFilled
        );

        // 3️⃣ Logged-in user slot usage
        $userSlotsUsed = 0;

        if (session()->get('user_logged_in')) {
            $userId = session()->get('user_id');

            $enrollment = $enrollModel->getUserEnrollment($userId, $planId);
            if ($enrollment) {
                $userSlotsUsed = $enrollment['slots_used'];
            }
        }

        // 4️⃣ Send data to view
        return view('frontend/plan_view', [
            'plan'           => $plan,
            'slotsRemaining' => $slotsRemaining,
            'userSlotsUsed'  => $userSlotsUsed
        ]);
    }
}
