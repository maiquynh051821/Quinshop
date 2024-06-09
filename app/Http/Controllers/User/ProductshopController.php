<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Product\ProductService;
class ProductshopController extends Controller
{
   protected $productService;
   public function __construct(ProductService $productService)
   {
      $this->productService = $productService;
   }
   public function index($id = '',$slug = '')
   {
      $product = $this->productService->show($id); //kiem tra co ton tai trong data hay khong
      if (!$product) {
         abort(404, 'Không tìm thấy sản phẩm');
      }
      return view('user.products.content',[
         'title' => $product->name,
         'product' => $product,
      ]);
   }
   public function like(Product $product)
{
    $user = Auth::user();
    if (!$user->favoriteProducts()->where('product_id', $product->id)->exists()) {
        $user->favoriteProducts()->attach($product->id);
    } else {
        $user->favoriteProducts()->detach($product->id);
    }
    return redirect()->route('home')->with('message', 'Product like status updated.');
}

public function unlike(Product $product)
{
    $user = Auth::user();
    if ($user->favoriteProducts()->where('product_id', $product->id)->exists()) {
        $user->favoriteProducts()->detach($product->id);
    }
    return redirect()->route('home')->with('message', 'Product unlike status updated.');
}

}

