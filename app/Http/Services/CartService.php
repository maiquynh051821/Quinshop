<?php


namespace App\Http\Services;

use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Admin\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartService
{
    public function create($request)
    {
        $qty = (int) $request->input('num_product');
        $product_id = (int) $request->input('product_id');
        $size = $request->input('size');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc sản phẩm không chính xác');
            return false;
        }

        if ($size === null) {
            Session::flash('error', 'Vui lòng chọn size');
            return false;
        }

        $carts = Session::get('carts', []);
        $cartKey = $product_id . '-' . $size;

        if (isset($carts[$cartKey])) {
            $carts[$cartKey]['quantity'] += $qty;
            // Log::info('Tăng số lượng sản phẩm trong giỏ hàng', ['cartKey' => $cartKey, 'quantity' => $carts[$cartKey]['quantity']]);
        } else {
            $carts[$cartKey] = [
                'product_id' => $product_id,
                'quantity' => $qty,
                'size' => $size
            ];
            // Log::info('Thêm mới sản phẩm vào giỏ hàng', ['cartKey' => $cartKey]);
        }

        //  Kiểm tra phần tử không hợp lệ nào trong giỏ hàng
        foreach ($carts as $key => $value) {
            if (strpos($key, '-') === false || !isset($value['quantity']) || !isset($value['size'])) {
                unset($carts[$key]);  // Loại bỏ phần tử không hợp lệ
            }
        }

        Log::info('Session before save in create method', ['session' => Session::all()]);
        Session::put('carts', $carts);
        Session::save();
        Log::info('Session after save in create method', ['session' => Session::all()]);
        // dd($carts);
        return true;
    }

    public function getProduct()
    {

        Log::info('Session before retrieval in getProduct method', ['session' => Session::all()]);
        $carts = Session::get('carts', []);
        Log::info('Session after retrieval in getProduct method', ['session' => Session::all()]);
        //    dd($carts);

        if (count($carts) == 0) {
            return [];
        }


        $productIds = array_map(function ($key) {
            return explode('-', $key)[0];
        }, array_keys($carts));
        $productIds = array_unique($productIds);

        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productIds)
            ->get();

        $productDetails = [];
        foreach ($products as $product) {
            foreach ($carts as $key => $details) {
                list($productId, $size) = explode('-', $key);
                if ($productId == $product->id) {
                    $productDetails[] = [
                        'product' => $product,
                        'size' => $details['size'],
                        'quantity' => $details['quantity']
                    ];
                }
            }
        }

        return $productDetails;
    }
}
