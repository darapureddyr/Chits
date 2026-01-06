<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanModel extends Model
{
    protected $table            = 'plans';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

  protected $allowedFields = [
    'plan_name',
    'plan_code',
    'chit_amount',
    'total_slots',
    'max_slots_per_user',
    'commission_amount',
    'total_commission_per_month',
    'description',
    'status'
];


    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /* =========================================
       ADMIN METHODS
    ========================================= */

    /**
     * Get all plans (admin)
     */
    public function getAllPlans()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }

    /**
     * Get single plan by ID
     */
    public function getPlanById($planId)
    {
        return $this->where('id', $planId)->first();
    }

    /**
     * Check duplicate plan code
     */
    public function isPlanCodeExists($planCode)
    {
        return $this->where('plan_code', $planCode)->first();
    }

    /* =========================================
       FRONTEND METHODS
    ========================================= */

    /**
     * Get all visible plans (open / running / full)
     */
    public function getVisiblePlans()
    {
        return $this->whereIn('status', [1, 2, 3])
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Get plan only if not closed
     */
    public function getActivePlan($planId)
    {
        return $this->where('id', $planId)
                    ->whereIn('status', [1, 2, 3])
                    ->first();
    }
}
