<?php

namespace App\Http\Services\Menu;

use Illuminate\Support\Str;
use App\Models\Admin\Menu;
use Illuminate\Support\Facades\Session;

class MenuService
{
    // Phuong thuc tra ve tat ca cac menu ma khong co menu cha (parent_id=0)
    // Sdung truy van de lay ra cac ban ghi tu bang Menu co parent_id = 0 va tra ve ket qua duoi dang 1 collection
    public function getParent()
    {
        return Menu::where("parent_id", 0)->get();
    }

    // Phương thức này trả về tất cả các menu từ cơ sở dữ liệu, được sắp xếp theo id theo thứ tự giảm dần (orderByDesc) 
    // và được phân trang với mỗi trang chứa tối đa 20 menu. Sử dụng phương thức paginate() của Laravel để phân trang kết quả trả về
    public function getAll()
    {
        return Menu::orderByDesc("id")->paginate(20);
    }

    // Phương thức này thực hiện việc tạo mới một menu trong cơ sở dữ liệu dựa trên dữ liệu được gửi từ biểu mẫu (request).
    public function create($request)
    {
        try {
            Menu::create([
                'name' => (string) $request->input('name'),
                'parent_id' => (string) $request->input('parent_id'),
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'active' => (string) $request->input('active'),
            ]);

            Session::flash('success', 'Tạo danh mục thành công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    // Xóa 1 danh mục 
    public function destroy($request)
    {
        $id = (int) $request->input('id');
       $menu = Menu::where('id',$id)->first();
       if($menu){
        return Menu::where('id',$id)->orWhere('parent_id',$id)->delete();
       }
       return false;
    }
}
