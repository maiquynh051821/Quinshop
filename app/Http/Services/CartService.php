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
        Session::put('carts', $carts);
        Session::save();
        // dd($carts);
        // Log::info('Updated carts in create method', ['carts' => Session::get('carts')]);
        return true;
    }

    public function getProduct()
    {
        // Log::info('Retrieved carts in getProduct method', ['carts' => Session::get('carts')]);
        $carts = Session::get('carts', []);
        //    dd($carts);
        // Log::info('Final carts in getProduct method', ['carts' => $carts]);

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
                $parts = explode('-', $key);
                if (count($parts) == 2) {
                    list($productId, $size) = $parts;
                    if ($productId == $product->id) {
                        $productDetails[] = [
                            'product' => $product,
                            'size' => $details['size'],
                            'quantity' => $details['quantity']
                        ];
                    }
                } else {
                    // Tùy chọn xử lý lỗi hoặc bỏ qua mục nhập này
                    Log::error("Định dạng khóa giỏ hàng không hợp lệ: $key");
                }
            }
        }

        return $productDetails;
    }
    public function update($request)
    {
        $products = $request->input('products');
        $carts = Session::get('carts', []);

        foreach ($products as $productId => $sizes) {
            foreach ($sizes as $size => $details) {
                $quantity = (int) $details['quantity'];

                $cartKey = $productId . '-' . $size;
                if (!isset($carts[$cartKey])) {
                    continue; // Bỏ qua nếu sản phẩm không tồn tại
                }


                $carts[$cartKey]['quantity'] = $quantity; // Cập nhật số lượng mới

            }
        }


        Session::put('carts', $carts); // Lưu lại giỏ hàng đã cập nhật vào session
        Session::save();
        Session::flash('success', 'Cập nhật số lượng thành công');
        return true;
    }

    public function remove($request)
    {
        $productId = $request->input('product_id');
        $size = $request->input('size');
        $carts = Session::get('carts', []);
        $cartKey = $productId . '-' . $size;
        Log::debug('Attempting to remove product', ['product_id' => $productId, 'size' => $size, 'key' => $cartKey]);
        Log::info($carts);
        if (isset($carts[$cartKey])) {
            unset($carts[$cartKey]);
            Session::put('carts', $carts);
            Session::save(); // Đảm bảo lưu lại session sau khi thay đổi
            // Log::debug('Cart after removal', ['carts' => Session::get('carts')]);
            Log::info($carts);
            Session::flash('success', 'Xóa thành công sản phẩm');
        } else {

            // Log::debug('Failed to remove product', ['product_id' => $productId, 'size' => $size, 'key' => $cartKey]);
            Session::flash('success', 'Xóa không thành công sản phẩm');
        }
    }

    public function addCart($request)
    {
        try {
            DB::beginTransaction(); //Bat dau 1 giao dich trong DB. Neu chay bi loi se rollBack lai trang thai truoc khi bat dau
            $carts = Session::get('carts');

            if (is_null($carts))
                return false;

            $customer = Customer::create([
                'user_id' => $request->input('user_id'),
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'content' => $request->input('content'),
                'pay_method' => $request->input('pay_method')
            ]);

            $this->infoProductCart($carts, $customer->id); // Gọi pthuc infoProductCart để lưu thông tin sản phẩm trong giỏ hàng vào bảng carts
            DB::commit();
            Session::flash('success', 'Đặt hàng thành công');
            // Lấy lại giỏ hàng từ database
            $updatedCarts = $this->getCartByCustomerId($customer->id);
            #Gửi mail sau khi đặt hàng
            $email = $customer->email;
            Sendmail::dispatch($email, $customer, $updatedCarts)->delay(now()->addSeconds(3)); // Sau khi dat hang 3s, tien hanh gui mail

            Session::forget('carts'); // Xóa giỏ hàng sau khi đặt hàng thành công
        } catch (\Exception $err) {
            DB::rollBack(); //Neu loi se khoi phuc lai trang thai ban dau
            Session::flash('success', 'Đã xảy ra lỗi, vui lòng thử lại sau');
            return false;
        }
        return true;
    }

    protected function infoProductCart($carts, $customer_id)
    {
        // Lặp qua từng sản phẩm trong giỏ hàng để lưu thông tin
        foreach ($carts as $cartKey => $cartItem) {
            $productInfo = explode('-', $cartKey);
            $productId = $productInfo[0];
            $size = $productInfo[1];
            $quantity = $cartItem['quantity'];
            // Truy vấn sản phẩm để lấy giá , ten , anh
            $product = Product::findOrFail($productId);
            $price = $product->price_sale != 0 ? $product->price_sale : $product->price;
            $name = $product->name;
            $thumb = $product->thumb;
            // Tạo bản ghi mới trong bảng carts
            Cart::create([
                'customer_id' => $customer_id,
                'product_id' => $productId,
                'name' => $name,
                'thumb' => $thumb,
                'size' => $size,
                'qty' => $quantity,
                'price' => $price
            ]);
        }
    }
    public function getCartByCustomerId($customer_id)
    {
        return Cart::where('customer_id', $customer_id)->get();
    }
}
