<?php

namespace App\Http\Controllers;
use App\Models\PaymentModel;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\PayosUserModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use PayOS\PayOS;

class SuccessController extends Controller
{
    public function __construct()
    {
    }
    public function successPayment(Request $request) {
        $data=$request->all();
        $userId = Auth::user()->id;
        $customer = Customer::where('user_id', $userId)->latest()->first();
        $payosUser = PayosUserModel::where('customer_id',$customer->id)->first();
       if($data['status'] == 'PAID' && $customer){
            $payosUser->status = 1;
            $payosUser->save();
            $dataMail = Session::get('dataMail');
            Mail::send('mail.success', $dataMail, function ($email) use ($customer) {
                $email->to($customer->email);
                $email->subject('Thông báo Shop Quin');
            });
            return redirect()->route('cart_list',['customer_id'=>$customer->id]);
       }
       return redirect()->route('user');
    }
    public function cancelPayment(Request $request) {
        $data=$request->all();
        $userId = Auth::user()->id;
        $customer = Customer::where('user_id', $userId)->latest()->first();
        $payosUser = PayosUserModel::where('customer_id',$customer->id)->first();
        $payosUser->delete();
        $cart = Cart::where('customer_id',$customer->id)->delete();
        $customer->delete();
        return redirect()->route('user');
    }
}
