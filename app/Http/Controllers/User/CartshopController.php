<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Session;

class CartshopController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Them san pham vao gio hang 
    public function index(Request $request)
    {
        $result = $this->cartService->create($request);
        if ($result === false) {
            return redirect()->back()->with('error', Session::get('error'));
        }
        return redirect('/carts');
    }

    public function show()
    {
        $products = $this->cartService->getProduct();
        // dd($products);
        return view('user.carts.list', [
            'title' => "Giỏ hàng",
            'products' => $products,
            'carts' => session::get('carts')
        ]);
    }

    //Cap nhat san pham
    public function update(Request $request)
    {
        $this->cartService->update($request);
        return redirect('/carts');
    }
    // Xoa san pham khoi gio hang
    public function remove(Request $request)
    {
        $this->cartService->remove($request);
        return redirect('/carts');
    }
}
