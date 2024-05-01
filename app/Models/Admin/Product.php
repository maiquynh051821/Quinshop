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

    public function menu()
    {
        return $this->hasOne(Menu::class,'id','menu_id'); // 'id':khoa chinh, 'menu_id':khoa phu
        
    }
}
