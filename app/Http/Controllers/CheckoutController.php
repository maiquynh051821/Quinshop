<?php

namespace App\Http\Controllers;

use App\Models\PaymentModel;
use App\Models\PayosUserModel;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\ProductModel;
use PayOS\PayOS;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
  public function __construct()
  {
  }
  
  
  public function createPaymentLink(Request $request)
  {
  
      $data = $request->all();
      $mailUser = $data['email'];
      $amount = floatval($data['amount']);
      $customer = new Customer();
      $customer->user_id = $data['user_id'];
      $customer->name = $data['name'];
      $customer->phone = $data['phone'];
      $customer->address = $data['address'];
      $customer->email = $data['email'];
      $customer->content = $data['content'];
      $customer->pay_method = $data['pay_method'];
      $customer->pay_status = 0;
      $customer->save();

      $sanphamgiohang = $data['sanphamgiohang'];
      
      foreach($sanphamgiohang as $item){
        $cart = new Cart();
        $cart->customer_id = $customer->id;
        $cart->product_id = $item['id'];
        $cart->thumb = $item['thumb'];
        $cart->size = $item['size'];
        $cart->qty = $item['quantity'];
        $cart->price = $item['price'];
        $cart->name = $item['name'];
        $cart->save();
      }
      $dataMail = [
        'customer' => $customer,
        'updatedCarts' => $sanphamgiohang,
    ];
    Mail::send('mail.success', $dataMail, function ($email) use ($customer) {
      $email->to($customer->email);
      $email->subject('Thông báo Shop Quin');
  });
      
      // tiền mặt == 1 ; chuyển khoản == 2
      $customer_id = $customer->id;
      if($data['pay_method'] == 1){
        $payos = new PayosUserModel();
        $payos->customer_id =  $customer->id;
        $payos->amount = $amount;
        $payos->status = 1;
        $payos->save();
        $customer->pay_status = 1;
        $customer->save();
        Session::forget('carts');
        return redirect()->route('cart_list',['customer_id'=>$customer->id]);
      }else if($data['pay_method'] == 2){
        $payos = new PayosUserModel();
        $payos->customer_id =  $customer->id;
        $payos->amount = $amount;
        $payos->status = 0;
        $payos->save();
        Session::forget('carts');
        $YOUR_DOMAIN = "http://127.0.0.1:8000"; 
        $ordercode = intval(substr(strval(microtime(true) * 10000), -6));
        
        if ($amount <= 0.01 || $amount > 10000000000) {
          return "Số tiền không hợp lệ!";
        }
  
        $data = [
          "customer" => $customer->id,
          "orderCode" => $ordercode,
          "amount" => $amount,
          "description" => $ordercode . $data['phone'],
          "returnUrl" => $YOUR_DOMAIN . "/success",
          "cancelUrl" => $YOUR_DOMAIN . "/cancel"
        ];
  
        error_log($data['orderCode']);
  
        $PAYOS_CLIENT_ID = env('PAYOS_CLIENT_ID');
        $PAYOS_API_KEY = env('PAYOS_API_KEY');
        $PAYOS_CHECKSUM_KEY = env('PAYOS_CHECKSUM_KEY');
  
        $payOS = new PayOS($PAYOS_CLIENT_ID, $PAYOS_API_KEY, $PAYOS_CHECKSUM_KEY);
        try {
          $response = $payOS->createPaymentLink($data);
          return redirect($response['checkoutUrl']);
          // $response = $payOS->getPaymentLinkInfomation($data['orderCode']);
          // return $response;
        } catch (\Throwable $th) {
          return $th->getMessage();
        }
      }
      
    
  }
}