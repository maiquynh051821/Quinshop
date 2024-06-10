<?php

namespace App\Http\Services\Menu;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Menu;
use App\Models\Admin\Product;
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
        return Menu::orderByDesc('id')->get();
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
            //Neu danh muc cha bị non-active, cập nhật tất cả danh mục con và san pham cua dmuc do la non-active
            if ($menu->active == 0) {
                $this->updateNonactive($menu->id);
            } else {
                $this->updateActive($menu->id);
            }
            Session::flash('success', 'Cập nhật thành công danh mục: ' . $menu->name);
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật không thành công danh mục: ' . $menu->name);
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }
    //Phuong thuc de cap nhat trang thai cua danh muc con va san pham
    private function updateNonactive($parentId)
    {
        $childMenus = Menu::where('parent_id', $parentId)->get();
        foreach ($childMenus as $childMenu) {
            $childMenu->active = '0';
            $childMenu->save();
            $this->updateNonactive($childMenu->id);
        }

        $products = Product::where('menu_id', $parentId)->get();
        foreach ($products as $product) {
            $product->active = '0';
            $product->save();
        }
    }
    private function updateActive($parentId)
    {
        $childMenus = Menu::where('parent_id', $parentId)->get();
        foreach ($childMenus as $childMenu) {
            $childMenu->active = '1';
            $childMenu->save();
            $this->updateActive($childMenu->id);
        }

        $products = Product::where('menu_id', $parentId)->get();
        foreach ($products as $product) {
            $product->active = '1';
            $product->save();
        }
    }

    //
    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail(); // Kiem tra id neu co thi ok neu khong thi bao loi
    }
    public function getProduct($menu, $request)
    {
        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);
        if ($request->input('sort_price')) {
            $sortOrder = $request->input('sort_price'); // asc hoặc desc

            // Sắp xếp theo giá sale nếu có, nếu không thì theo giá gốc
            $query->orderByRaw('COALESCE(price_sale, price) ' . $sortOrder);
        }
        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
    
}
