<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Product\ProductService;
class ProductshopController extends Controller
{
   protected $productService;
   public function __construct(ProductService $productService)
   {
      $this->productService = $productService;
   }
   public function index($id = '',$slug='')
   {
      $product = $this->productService->show($id); //kiem tra co ton tai trong data hay khong
     
      return view('user.products.content',[
         'title' => $product->name,
         'product' => $product,
      ]);
   }
}
