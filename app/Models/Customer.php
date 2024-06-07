<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'email',
        'content',
        'pay_method'
    ];

    public function carts() // 1 khach hang co the co nhieu san pham
    {
        return $this->hasMany(Cart::class,'customer_id','id');
    }

}
