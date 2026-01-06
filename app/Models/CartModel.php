<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart_items';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'product_id',
        'slots',
        'created_at'
    ];

    protected $useTimestamps = false;
}
