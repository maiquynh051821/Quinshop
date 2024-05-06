<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $productService;
    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        return view('admin.product.list',[
            'title' => 'Danh sách sản phẩm',
            'products' => $this->productService->get(),
        ]);
    }
    // Tao san pham 
    public function create()
    {
        return view("admin.product.add",[
            'title' => 'Thêm sản phẩm mới',
            'menus' => $this->productService->getMenu(),
        ]);
    }

    /**
     * Luu san pham
     */
    public function store(ProductRequest $request)
    {
        $this->productService->insert($request);
        return redirect()->back();
    }

    /**
     * Hien thi man hinh edit san pham
     */
    public function show(Product $product) //tu dong kiem tra id/san pham co trong data hay chua
    {
        return view('admin.product.edit',[
            'title' => 'Chỉnh sửa sản phẩm: ' . $product->name,
            'product' => $product,
            'menus' => $this->productService->getMenu(),
        ]);
    }


    /**
     * Update san pham.
     */
    public function update(Request $request, Product $product)
    {
        $result = $this->productService->update($request,$product);
        if($result){
            return redirect('/admin/products/list');
        }
       
        return redirect()->back();
    }

    /**
     * Xoa san pham
     */
    public function destroy(Request $request)
    {
        $result = $this->productService->delete($request);
        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công sản phẩm',
            ]);
        }
        return response()->json(['error' => true]);
    }
}
