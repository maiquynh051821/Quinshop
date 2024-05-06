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

    #Kiem tra gia giam so voi gia goc
    protected function isValidPrice($request)
    {
        if (
            $request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá Sale phải nhỏ hơn giá gốc');
            return false;
        }
        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error','Vui lòng nhập giá gốc');
            return false;
        }
        return true;
    }

    #Them san pham
    public function insert($request)
    {
       $isValidPrice = $this->isValidPrice($request);
       if($isValidPrice == false) return false;

       try{
        $request->except('_token'); // lấy tất cả các dữ liệu gửi trong request ngoại trừ trường có tên là _token
        Product::create($request->all());
        Session::flash('success','Thêm sản phẩm thành công ');
       }catch(\Exception $err){
        Session::flash('error','Thêm sản phẩm không thành công');
        Log::info($err->getMessage()); //Ghi log loi
        return false;
       }
      
    }

    #Hien thi danh sach san pham

    public function get()
    {
       return Product::with('menu') // 'menu' la relationship trong Models/Admin/Product
       ->orderByDesc('id')->paginate(10);
    }

    #Cap nhat san pham
    public function update($request,$product)
    {
        $isValidPrice = $this->isValidPrice($request);
       if($isValidPrice == false) return false;
       try{
        $product->fill($request->input());
        $product->save();
        Session::flash('success','Cập nhật thành công');
       }catch(\Exception $err){
        Session::flash('error','Cập nhật không thành công');
        Log::info($err->getMessage());
        return false;
       }
       return true;
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
