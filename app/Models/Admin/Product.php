<?php

namespace App\Models\Admin;

use App\Models\User;
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
    'likes',
    'thumb', 
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class,'id','menu_id')// 'id':khoa chinh, 'menu_id':khoa phu
        ->withDefault(['name'=>'']);
    }

    //Thiet lập mqh nhiều - nhiều với model User
    public function likeByUsers()
    {
        return $this->belongsToMany(User::class,'product_user_likes')->withTimestamps();
    }
}
