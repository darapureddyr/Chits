<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'mobile', 'password'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
