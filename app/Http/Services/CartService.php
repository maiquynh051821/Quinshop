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
                'quantity' => $qty,
                'size' => $size
            ];
            // Log::info('Thêm mới sản phẩm vào giỏ hàng', ['cartKey' => $cartKey]);
        }

        // Đảm bảo rằng không có phần tử không hợp lệ nào trong giỏ hàng
        foreach ($carts as $key => $value) {
            if (strpos($key, '-') === false || !isset($value['quantity']) || !isset($value['size'])) {
                unset($carts[$key]);  // Loại bỏ phần tử không hợp lệ
            }
        }
        Session::put('carts', $carts);
        Session::save();  // Đảm bảo lưu session sau khi cập nhật

        Log::info('Giỏ hàng đã được cập nhật', ['carts' => Session::get('carts')]);
        return true;
    }
}
