<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayosUserModel extends Model
{
    use HasFactory;
    protected $table = 'payos_user';
    protected $primariKey = 'id';
}
