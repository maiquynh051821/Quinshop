<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\CommentModel;
use App\Models\FavorivteModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Product\ProductService;

class ProductshopController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index($id = '', $slug = '')
    {
        $product = $this->productService->show($id); //kiem tra co ton tai trong data hay khong
        if (!$product) {
            abort(404, 'Không tìm thấy sản phẩm');
        }
        return view('user.products.content', [
            'title' => $product->name,
            'product' => $product,
        ]);
    }

    public static function getCommnet($id){
        $comment = CommentModel::where('product_id',$id)->where('STATUS',1)->get();
        return $comment;
    }
    public function like(Product $product)
    {
        $user = Auth::user();
        if (!$user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->attach($product->id);
        } else {
            $user->favoriteProducts()->detach($product->id);
        }
        return redirect()->back();
    }

    public function unlike(Product $product)
    {
        $user = Auth::user();
        if ($user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->detach($product->id);
        }
        return redirect()->back();
    }
    public function show()
    {
        $user = Auth::user();
        $favoriteProducts = $user->favoriteProducts()->paginate(12);
        // Log::info("San pham duoc yeu thich",$favoriteProducts);
        // Log::error("");
        return view('user.like', [
            'title' => 'Danh sách sản phẩm đã thích',
            'products' => $favoriteProducts,
        ]);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name','LIKE','%' . $query . '%')->get();
        return view('user.result', compact('products','query'),[
            'title' => 'Danh sách kết quả tìm kiếm',
        ]);
    }

    public function getLikeMax(){
        $favoriteProducts = FavorivteModel::selectRaw('product_id, COUNT(*) as count')
        ->groupBy('product_id')
        ->orderBy('count', 'desc')
        ->limit(12)
        ->get();

        $productIds = $favoriteProducts->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productIds)->get();
        $title = 'Sản phẩm được yêu thích nhất';
        return view('user.trending',compact('products','title'));
    }
}