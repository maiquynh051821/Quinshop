<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Models\Customer;
use App\Models\Cart;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartService $cart)
    {
         $this->cart = $cart;
    }
    public function index()
    {
        return view('admin.carts.customer',[
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $this->cart->getCustomer()

        ]);
    }
    public function show(Customer $customer)
    {
        return view('admin.carts.detail',[
            'title' => 'Chi tiết đơn hàng : '. $customer->name,
            'customer' => $customer,
            'carts' => $customer->carts()->get()
        ]);
    }

    public function cartStatus(Request $request){
        $data = $request->all();
        $cart = Cart::where('id',$data['cart_id'])->first();
        $cart->cart_status = $data['cart_status'];
        $cart->save();
        return redirect()->back()->with('success', 'Thay đổi trạng thái thành công');
    }
}
