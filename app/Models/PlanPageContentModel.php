<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanPageContentModel extends Model
{
    protected $table = 'plan_page_content';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        // Title
        'plan_page_title',

        // Labels
        'monthly_amount_label',
        'duration_label',
        'total_members_label',
        'start_date_label',
        'bid_date_label',
        'end_date_label',
        'base_price_label',
        'commission_label',

        // Info / helper text (UX)
        'slot_info',
        'bidding_info',
        'base_price_info',
        'commission_info',

        // CTA & agreement
        'add_to_cart_label',
        'agree_checkbox_text',

        // Meta
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
