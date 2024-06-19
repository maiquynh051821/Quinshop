<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavorivteModel extends Model
{
    use HasFactory;
    protected $table = 'favorite_products';
    protected $primariKey = 'id';
}
