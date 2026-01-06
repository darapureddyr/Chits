<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentLogModel extends Model
{
    protected $table            = 'enrollment_logs';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'user_id',
        'plan_id',
        'slot_no',
        'enrolled_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // not used

    /* =========================================
       CORE METHODS
    ========================================= */

    /**
     * Log a slot enrollment (INSERT ONLY)
     */
    public function logEnrollment($userId, $planId, $slotNo)
    {
        return $this->insert([
            'user_id'     => $userId,
            'plan_id'     => $planId,
            'slot_no'     => $slotNo,
            'enrolled_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get enrollment history for a user in a plan
     */
    public function getUserPlanLogs($userId, $planId)
    {
        return $this->where([
                'user_id' => $userId,
                'plan_id' => $planId
            ])
            ->orderBy('slot_no', 'ASC')
            ->findAll();
    }

    /**
     * Admin: get full enrollment logs for a plan
     */
    public function getPlanLogs($planId)
    {
        return $this->db->table('enrollment_logs l')
            ->select('
                u.uid,
                u.first_name,
                u.last_name,
                l.slot_no,
                l.enrolled_at
            ')
            ->join('users u', 'u.id = l.user_id')
            ->where('l.plan_id', $planId)
            ->orderBy('l.enrolled_at', 'ASC')
            ->get()
            ->getResultArray();
    }
}
