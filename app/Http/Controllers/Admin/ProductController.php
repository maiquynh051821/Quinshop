<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\Product;
use App\Models\Admin\SizeModel;
use App\Models\CommentModel;
use App\Models\FavorivteModel;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\PayosUserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

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
     * Xoa san pham
     */
    public function destroy(Request $request)
    {
       
        $data = $request->all();
        $products = Product::where('id', $data['product_id'])->first();
        // xoa yeu thich san pham
        $favorite = FavorivteModel::where('product_id', $data['product_id']);
        $favorite->delete();

        $sizes = SizeModel::where('product_id', $data['product_id']);
        $sizes->delete();

        $comment = CommentModel::where('product_id', $data['product_id']);
        $comment->delete();

        $cart = Cart::where('product_id', $data['product_id'])->get();
        if($cart->count() == 1){
            $cumtomer = Customer::where('id',$cart[0]->customer_id)->first();
            $payos = PayosUserModel::where('customer_id',$cumtomer->id)->delete();
            $cart = Cart::where('product_id', $data['product_id']);
            $cart->delete();
            $cumtomer->delete();
        }else{
            $cart = Cart::where('product_id', $data['product_id']);
            $cart->delete();
        }

        
       

        $products->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa thành công');

    }

    
    #Kiem tra gia giam so voi gia goc
    protected function isValidPrice($request)
    {
        if (
            $request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            // Session::flash('error', 'Giá Sale phải nhỏ hơn giá gốc');
            return false;
        }
        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            // Session::flash('error','Vui lòng nhập giá gốc');
            return false;
        }
        return true;
    }

    //Them sản phẩm
    public function store_product(Request $request){
        $isValidPrice = $this->isValidPrice($request);
        if($isValidPrice == false) return redirect()->back()->with('error', 'Giá không hợp lệ: yêu cầu nhập giá sale nhỏ hơn giá gốc và để nhập giá sale phải có giá gốc');
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
        // Kiểm tra nếu có tồn tại 'size' trong $data
        if (isset($data['size']) && is_array($data['size'])) {
            foreach ($data['size'] as $item) {
                $productSize = new SizeModel();
                $productSize->product_id = $product->id;
                $productSize->size = $item;
                $productSize->save();
            }
        }
        
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm thành công');
        
    }

    //Cap nhat san pham
    public function update_product(Request $request){
        $isValidPrice = $this->isValidPrice($request);
        if($isValidPrice == false) return redirect()->back()->with('error', 'Giá không hợp lệ: yêu cầu nhập giá sale nhỏ hơn giá gốc và để nhập giá sale phải có giá gốc');
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
        if (isset($data['size']) && is_array($data['size'])) {
        foreach($data['size'] as $item){
            $productSize = new SizeModel();
            $productSize->product_id = $product->id;
            $productSize->size = $item;
            $productSize->save();
        }}
        
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
    
    public function search(Request $request){
        $name_product = $request->input('name_product');
        $products = Product::where('name', 'like', '%'.$name_product.'%')->paginate(30);
        return view('admin.product.list',[
            'title' => 'Danh sách sản phẩm',
            'products' => $products,
        ]);
    }

    public function list_comment(){
        $comments = CommentModel::select('comment.id as comment_id', 'comment.*', 'products.*')
        ->join('products', 'products.id', '=', 'comment.product_id')
        ->paginate(20);
        return view('admin.product.list_comment',[
            'title' => 'Danh sách sản phẩm',
            'products' => $comments,
        ]);
    }

    public function status_comment($id){
        $comments = CommentModel::where('id',$id)->first();
        if($comments->STATUS == 1){
            $comments->STATUS = 0;
        }else{
            $comments->STATUS = 1;
        }
        $comments->save();
        return redirect()->back()->with('success', 'Bạn đã chỉnh sửa trạng thái thành công');
    }

    
}