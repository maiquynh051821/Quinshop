<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'parent_id',
        'description',
        'content',
        'active'
    ];
    public function products()
    {
        return $this->hasMany(Product::class,'menu_id','id'); // 1 menu co nhieu san pham
    }
}