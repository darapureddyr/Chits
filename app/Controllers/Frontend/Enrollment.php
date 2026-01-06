<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PlanModel;
use App\Models\EnrollmentModel;
use App\Models\EnrollmentLogModel;

class Enrollment extends BaseController
{
    public function enroll($planId)
    {
        // 🔐 USER LOGIN CHECK
        if (!session()->get('user_logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        $planModel       = new PlanModel();
        $enrollModel     = new EnrollmentModel();
        $enrollLogModel  = new EnrollmentLogModel();

        // =========================
        // 1️⃣ LOAD PLAN
        // =========================
        $plan = $planModel->getActivePlan($planId);

        if (!$plan) {
            return redirect()->back()->with('error', 'Invalid or closed plan');
        }

        // =========================
        // 2️⃣ CHECK PLAN FULL
        // =========================
        $totalFilled = $enrollModel->getTotalSlotsFilled($planId);

        if ($totalFilled >= $plan['total_slots']) {
            return redirect()->back()->with(
                'error',
                'All slots are filled for this plan'
            );
        }

        // =========================
        // 3️⃣ GET / CREATE ENROLLMENT ROW
        // =========================
        $enrollment = $enrollModel->getUserEnrollment($userId, $planId);

        if (!$enrollment) {
            $enrollModel->createEnrollmentIfNotExists($userId, $planId);
            $enrollment = $enrollModel->getUserEnrollment($userId, $planId);
        }

        // =========================
        // 4️⃣ CHECK USER SLOT LIMIT
        // =========================
        if ($enrollment['slots_used'] >= $plan['max_slots_per_user']) {
            return redirect()->back()->with(
                'error',
                'You have reached the maximum slots allowed for this plan'
            );
        }

        // =========================
        // 5️⃣ TRANSACTION START
        // =========================
        $db = \Config\Database::connect();
        $db->transStart();

        // Increment slot count
        $enrollModel->incrementSlot($userId, $planId);

        // Log slot history
        $slotNo = $enrollment['slots_used'] + 1;
        $enrollLogModel->logEnrollment($userId, $planId, $slotNo);

        // =========================
        // 6️⃣ TRANSACTION END
        // =========================
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Enrollment failed. Try again.');
        }

        return redirect()->back()->with('success', 'Slot enrolled successfully');
    }
}
