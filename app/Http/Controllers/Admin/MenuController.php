<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
class MenuController extends Controller
{
    protected $menuService;
    public function __construct(MenuService $menuService){
        $this->menuService = $menuService;
    }
    // Tao danh muc
    public function create()
    {
        return view("admin.menu.add", [
            "title" => "Thêm danh mục mới",
            "menus" => $this->menuService->getParent(),
        ]);
    }
    // Luu danh muc
    public function store(CreateFormRequest $request)
    {
      $result = $this->menuService->create($request);
      return redirect()->back();
    }
    // Hien thi danh sach danh muc
    public function index(){
        return view('admin.menu.list',[
            'title' => 'Danh sách danh mục',
            'menus' => $this->menuService->getAll(),
        ]);
    }
    public function destroy(Request $request){
      $result = $this->menuService->destroy($request);
      if($result){
        return response()->json([
        'error' => false,
        'message' => 'Xóa thành công danh mục'
        ]);
      }
      return response()->json([
        'error' => true
      ]);
    }
}
