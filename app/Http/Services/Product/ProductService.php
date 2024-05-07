<?php 

namespace App\Http\Services\Product;
use App\Models\Admin\Product;
class ProductService
{   
    const LIMIT =16;
    public function get($page = null)
    {
      return Product::select('id','name','price','price_sale','thumb')  
      ->orderByDesc('id')
      ->when($page != null, function ($query) use ($page){ //neu $page khong phai null, them 1 phan ofset vao truy vấn 
        $offset = $page * self::LIMIT;
        $query->offset($offset);
      })
      ->limit(self::LIMIT) // gioi han so lượng kết quả trả về mỗi lần
      ->get();
    }
}