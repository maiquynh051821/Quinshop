<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\CommentModel;

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


    public function showCheckout()
    {
        $products = $this->cartService->getProduct();
        $user = Auth::user();
        return view('user.carts.checkout', [
            'title' => 'Đơn hàng',
            'products' => $products,
            'user' => $user,
            'carts' => Session::get('carts')
        ]);
    }
    public function addCart(Request $request)
    {
        $data = $request->all();
        if ($data['pay_method'] == 1) {
            $result = $this->cartService->addCart($request);
            return redirect()->back();
        } else if ($data['pay_method'] == 2) {
            dd($data);
        }
    }

    public function cartList($customerId)
    {
        $customer = Customer::where('customers.id', $customerId)
            ->join('carts', 'carts.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'customers.*', 'carts.*')
            ->get();
        $title = 'Sản phầm vừa mua';
        return view('user.carts.list_cart', compact('customer', 'title'));
    }

    public function cartListUser()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id; // Lấy id của người dùng hiện tại đã đăng nhập
            $customer1 = Customer::where('user_id', $userId)
                ->where('customers.pay_method', 1)
                ->select('customers.id as customer_id', 'customers.*')
                ->get();

            $customer2 = Customer::where('user_id', $userId)
                ->where('customers.pay_method', 2)
                ->join('payos_user', 'payos_user.customer_id', '=', 'customers.id')
                ->where('payos_user.status', 1)
                ->select('customers.id as customer_id', 'customers.*')
                ->get();

            $customer = $customer1->merge($customer2);
            $customer = $customer->sortByDesc('created_at');
            $customer = $customer->values();


            $title = 'Tất cả sản phẩm bạn đã mua';
            return view('user.carts.list_cart_user', compact('customer', 'title'));
        } else {
            return redirect()->route('login');
        }
    }

    public static function getCart($customerId)
    {
        $cart = Cart::where('customer_id', $customerId)->get();
        return $cart;
    }

    public function comment(Request $request)
    {
        if (!$request->has('rating')) {
            return redirect()->back()->with('error', 'Bạn cần chọn số sao để đánh giá.');
        }
        $data = $request->all();
        $comment = new CommentModel();
        $comment->product_id = $data['product_id'];
        $comment->star = $data['rating'];
        $comment->comment = $data['comment'];
        $userId = Auth::user()->id;
        $comment->user_id = $userId;
        $comment->status = 0;
        $comment->save();
        return redirect()->back()->with('success', 'Bạn đã thêm bài nhận xét thành công.');
    }

    public function disCart($id)
    {
        $cart = Cart::where('id', $id)->first();
        $cart->cart_status = 3;
        $cart->save();
        return redirect()->back()->with('success', 'Bạn đã hủy đơn hàng thành công.');
    }

    public static function getPaymethod($id)
    {
        $pay_method = Customer::where('id', $id)->pluck('pay_method')->first();
        return $pay_method;
    }
}