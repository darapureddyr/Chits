<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // ✅ MUST match DB columns exactly
    protected $allowedFields = [
        'plan_name',
        'chit_amount',
        'total_members',
        'duration_months',

        'bidding_date',
        'start_date',
        'end_date',

        'base_price_per_month',
        'commission_per_month',

        'status',
        'created_at'
    ];

    protected $useTimestamps = false;
}
