<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Models\Customer;
use App\Models\Cart;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        $customers1 = Customer::join('payos_user', 'customers.id', '=', 'payos_user.customer_id')
            ->where('payos_user.status', 1)
            ->orderByDesc('customers.id')
            ->select(
                'customers.id as id',
                'customers.name',
                'customers.phone',
                'customers.address',
                'customers.email',
                'customers.content',
                'customers.pay_method',
                'customers.created_at as created_at',
                'customers.updated_at as updated_at',
            )->get();

        $customers2 =  Customer::where('pay_method', 1)->select(
            'customers.id as id',
            'customers.name',
            'customers.phone',
            'customers.address',
            'customers.email',
            'customers.content',
            'customers.pay_method',
            'customers.created_at as created_at',
            'customers.updated_at as updated_at',
        )->get();

        $customers = $customers1->merge($customers2);
        $customers = $customers->sortByDesc('created_at');
        $customers = $customers->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $startingPoint = ($page * $perPage) - $perPage;
        $slicedCollection = $customers->slice($startingPoint, $perPage)->values();

       
        $customers = new LengthAwarePaginator(
            $slicedCollection,
            $customers->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
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
