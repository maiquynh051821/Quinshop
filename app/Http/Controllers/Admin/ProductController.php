<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Menu\ProductAdminService;
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
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this->productService->insert($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) //tu dong kiem tra id/san pham co trong data hay chua
    {
        return view('admin.product.edit',[
            'title' => 'Chỉnh sửa sản phẩm',
            'product' => $product,
            'menus' => $this->productService->getMenu(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
