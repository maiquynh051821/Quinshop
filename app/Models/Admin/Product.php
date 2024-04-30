<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = 
    [
    'name', 
    'description', 
    'content',
    'menu_id',
    'price',
    'price_sale',
    'active',
     'thumb', 
    ];
}
