<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'user_id',
        'plan_id',
        'slots_used'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /* =========================================
       USER LEVEL METHODS
    ========================================= */

    /**
     * Get enrollment row for a user & plan
     */
    public function getUserEnrollment($userId, $planId)
    {
        return $this->where([
            'user_id' => $userId,
            'plan_id' => $planId
        ])->first();
    }

    /**
     * Create enrollment row if not exists
     */
    public function createEnrollmentIfNotExists($userId, $planId)
    {
        $exists = $this->getUserEnrollment($userId, $planId);

        if (!$exists) {
            return $this->insert([
                'user_id'    => $userId,
                'plan_id'    => $planId,
                'slots_used' => 0
            ]);
        }

        return $exists['id'];
    }

    /**
     * Increment slot count safely
     */
    public function incrementSlot($userId, $planId)
    {
        return $this->where([
                'user_id' => $userId,
                'plan_id' => $planId
            ])
            ->set('slots_used', 'slots_used + 1', false)
            ->update();
    }

    /* =========================================
       PLAN LEVEL METHODS (ADMIN)
    ========================================= */

    /**
     * Total slots filled in a plan
     */
    public function getTotalSlotsFilled($planId)
    {
        return (int) $this->where('plan_id', $planId)
                          ->selectSum('slots_used')
                          ->get()
                          ->getRow()
                          ->slots_used;
    }

    /**
     * Get all users enrolled in a plan (admin view)
     */
    public function getPlanEnrollments($planId)
    {
        return $this->db->table('enrollments e')
            ->select('
                u.uid,
                u.name,
                u.mobile,
                e.slots_used,
                e.created_at AS enrolled_at
            ')
            ->join('users u', 'u.id = e.user_id')
            ->where('e.plan_id', $planId)
            ->orderBy('e.created_at', 'ASC')
            ->get()
            ->getResultArray();
    }
}
