<?php namespace App\Models;

use CodeIgniter\Model;

class PlanSlotModel extends Model
{
    protected $table = 'plan_slots';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'plan_id',
        'user_id',
        'slot_uid',
        'is_used',
        'created_at'
    ];

    protected $useTimestamps = false;

    /* Get last slot number for a plan */
    public function getLastSlotNumber(int $planId): int
    {
        $row = $this->where('plan_id', $planId)
                    ->orderBy('id', 'DESC')
                    ->first();

        if (!$row) return 0;

        preg_match('/SLOT-(\d+)/', $row['slot_uid'], $m);
        return (int) ($m[1] ?? 0);
    }

    /* Get active slots of a user */
    public function getActiveSlotsByUser(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_used', 0)
                    ->findAll();
    }

    /* Mark slot as used (winner) */
    public function markUsed(int $slotId)
    {
        return $this->update($slotId, ['is_used' => 1]);
    }
}
