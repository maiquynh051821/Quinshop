<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\Product;
use App\Models\Admin\SizeModel;
use App\Models\CommentModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    public function comment()
    {
        return view('admin.product.comment',[
            'title' => 'Danh sách sản phẩm',
            'products' => $this->productService->get(),
        ]);
    }

    public function delatilcomment($id)
    {
        $title = 'Danh sách bình luận đánh giá';
        $comments = CommentModel::where('product_id',$id)->get();
        return view('admin.product.detail_comment',compact('comments','title'));
    }

    public function editcomment($id)
    {
        $title = 'Danh sách bình luận đánh giá';
        $comments = CommentModel::where('id',$id)->first();
        $status = $comments->STATUS;
        if($status == 1){
            $comments->STATUS = 0;
        }else{
            $comments->STATUS = 1;
        }
        $comments->save();
        return redirect()->back()->with('success', 'Thay đổi thành công');
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

    public function store_product(Request $request){
        $data = $request->all();
        $product = new Product();
        $product->name = $data['name'];
        $product->menu_id = $data['menu_id'];
        $product->price = $data['price'];
        $product->price_sale = $data['price_sale'];
        $product->description = $data['description'];
        $product->content = $data['content'];
        $product->active = $data['active'];
        $path_upload = 'uploads/images/';
        if (!File::exists(public_path($path_upload))) {
            File::makeDirectory(public_path($path_upload), 0755, true);
        }
        $filePaths = [];
        if($request->hasFile('file_img')){
            foreach($request->file('file_img') as $file){
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($path_upload), $filename);
                $filePaths[] = $path_upload . $filename;
            }
            $product->thumb = json_encode($filePaths);
        }

        $product->save();
        foreach($data['size'] as $item){
            $productSize = new SizeModel();
            $productSize->product_id = $product->id;
            $productSize->size = $item;
            $productSize->save();
        }
        
        return redirect()->back()->with('success', 'Sản phẩm đã được lưu thành công');
        
    }

    public function update_product(Request $request){
        $data = $request->all();
        $product =  Product::where('id',$data['product_id'])->first();
        $product->name = $data['name'];
        $product->menu_id = $data['menu_id'];
        $product->price = $data['price'];
        $product->price_sale = $data['price_sale'];
        $product->description = $data['description'];
        $product->content = $data['content'];
        $product->active = $data['active'];
        
        $path_upload = 'uploads/images/';
        if (!File::exists(public_path($path_upload))) {
            File::makeDirectory(public_path($path_upload), 0755, true);
        }
        $filePaths = [];
        if($request->hasFile('file_img')){
            foreach($request->file('file_img') as $file){
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($path_upload), $filename);
                $filePaths[] = $path_upload . $filename;
            }
            $product->thumb = json_encode($filePaths);
        }

        $product->save();
        $productSize = SizeModel::where('product_id',$data['product_id'])->delete();
        foreach($data['size'] as $item){
            $productSize = new SizeModel();
            $productSize->product_id = $product->id;
            $productSize->size = $item;
            $productSize->save();
        }
        
        return redirect()->back()->with('success', 'Sản phẩm đã được lưu thành công');
    }

    public static function getSizeByProductId($id){
        $productSize = SizeModel::where('product_id',$id)->get();
        return $productSize;
    }  
    
    public static function getSizeByProductIdSize($id){
        $productSize = SizeModel::where('product_id',$id)->pluck('size');
        return $productSize;
    }  
}