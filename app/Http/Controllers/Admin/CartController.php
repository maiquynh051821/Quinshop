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
        $customers = Customer::join('payos_user', 'customers.id', '=', 'payos_user.customer_id')
            ->where('payos_user.status', 1)
            ->orderByDesc('customers.id')
            ->select(
                'customers.id as id',
                'payos_user.id as payos_id',
                'customers.name',
                'customers.phone',
                'customers.address',
                'customers.email',
                'customers.content',
                'customers.pay_method',
                'customers.created_at as created_at',
                'customers.updated_at as updated_at',
                'payos_user.customer_id',
                'payos_user.amount',
                'payos_user.status as payos_status',
                'payos_user.created_at as payos_user_created_at'
            )
            ->paginate(15);
        $title = 'Danh sách đơn hàng';
        return view('admin.carts.customer', compact('customers', 'title'));
    }
    public function show(Customer $customer)
    {
        return view('admin.carts.detail', [
            'title' => 'Chi tiết đơn hàng : ' . $customer->name,
            'customer' => $customer,
            'carts' => $customer->carts()->get()
        ]);
    }

    public function cartStatus(Request $request)
    {
        $data = $request->all();
        $cart = Cart::where('id', $data['cart_id'])->first();
        $cart->cart_status = $data['cart_status'];
        $cart->save();
        return redirect()->back()->with('success', 'Thay đổi trạng thái thành công');
    }

    public static function checkStatusCart($customerId)
    {
        $carts = Cart::where('customer_id', $customerId)->get();
        $allCancelled = true;
        $anyProcessing = false;
        foreach ($carts as $cart) {
            if ($cart->cart_status == 0 || $cart->cart_status == 1) {
                return 'Chưa hoàn thành';
            } elseif ($cart->cart_status != 3) {
                $allCancelled = false;
                $anyProcessing = true;
            }
        }
        if ($allCancelled) {
            return 'Đã hủy';
        } elseif ($anyProcessing) {
            return 'Đã hoàn thành';
        } else {
            return 'Đã hoàn thành';
        }
    }

    public function search_carts(Request $request)
    {
        $name_phone = $request->input('name_phone');
        $customers = Customer::where('phone', 'like', '%' . $name_phone . '%')
            ->paginate(50);
        return view('admin.carts.customer', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $customers
        ]);
    }
}
