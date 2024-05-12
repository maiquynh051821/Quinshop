<?php

namespace App\Http\Services\Menu;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class MenuService
{
    // Phuong thuc tra ve tat ca cac menu ma khong co menu cha (parent_id=0)
    // Sdung truy van de lay ra cac ban ghi tu bang Menu co parent_id = 0 va tra ve ket qua duoi dang 1 collection
    public function getParent()
    {
        return Menu::where("parent_id", 0)->get();
    }

    // Phương thức này trả về tất cả các menu từ cơ sở dữ liệu, được sắp xếp theo id theo thứ tự giảm dần (orderByDesc) tăng dan(orderBy) 
    // và được phân trang với mỗi trang chứa tối đa 150 menu. Sử dụng phương thức paginate() của Laravel để phân trang kết quả trả về

    public function getAll()
    {
        return Menu::orderByDesc('id')->paginate(150);
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
        $menu = Menu::where('id', $id)->first();
        if ($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }
        return false;
    }

    // Cap nhat danh muc
    public function update($request, $menu)
    {
        // Kiểm tra xem parent_id mới có khác so với parent_id hiện tại không
        if ($request->input('parent_id') != $menu->id) {
            // Nếu khác, cập nhật parent_id
            $menu->parent_id = (int) $request->input('parent_id');
        }
        try {
            $menu->name = (string) $request->input('name');
            $menu->description = (string) $request->input('description');
            $menu->content = (string) $request->input('content');
            $menu->active = (string) $request->input('active');
            // $menu->fill($request->input()); // Quét toàn bộ thông tin mà request đã lấy thay cho 5 dòng bên trên
            $menu->save();
            Session::flash('success', 'Cập nhật thành công danh mục');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật không thành công');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function getId($id)
    {
        return Menu::where('id',$id)->where('active',1)->firstOrFail(); // Kiem tra id neu co thi ok neu khong thi bao loi
    }
    public function getProduct($menu){
        return $menu->products()
        ->select('id','name','price','price_sale', 'thumb')
        ->where('active',1)
        ->orderBy('id')
        ->paginate(12);
    }
}
