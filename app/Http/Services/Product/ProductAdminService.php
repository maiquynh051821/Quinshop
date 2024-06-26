<?php

namespace App\Http\Services\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Menu;
use App\Models\Admin\Product;
class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }


    #Hien thi danh sach san pham

    public function get()
    {
       return Product::with('menu') // 'menu' la relationship trong Models/Admin/Product
       ->orderByDesc('id')->paginate(10);
    }

  

    #Xoa san pham
    public function delete($request)
    {
      $product = Product::where('id',$request->input('id'))->first();  // Kiem tra ton tai khong 
      if($product){
        $product->delete();
        return true;
      }
      return false;
    }

}